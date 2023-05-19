<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Number Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
    <form id="form" class="row row-cols-lg-auto g-3 align-items-center position-absolute start-50 top-50 translate-middle" action="generator.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="dices">How many dices do you want to roll?</label>
            <input class="form-control" type="text" name="dices" id="dices">
        </div>
        <div>
            <label for="sides">How many sides of the dice?</label>
            <select class="form-select" name="sides" id="sides">
                <option disabled></option>
                <option value="4">d4</option>
                <option value="6">d6</option>
                <option value="8">d8</option>
                <option value="10">d10</option>
                <option value="12">d12</option>
                <option value="20">d20</option>
            </select>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>
    <div class="col-8 mt-2 mx-auto">
        <table class="table">
            <thead>
                <tr id="thead-row">

                </tr>
            </thead>
            <tbody>
                <tr id="tbody-row">

                </tr>
            </tbody>
        </table>
    </div>
    <script>
        form.onsubmit = async (e) => {
            e.preventDefault()

            let response = await fetch("generator.php", {
                method: "post",
                body: new FormData(e.target),
            })

            let result = await response.json()
            
            let theadRow = document.getElementById("thead-row")
            let tbodyRow = document.getElementById("tbody-row")

            // reset rows every new dice roll
            reset(theadRow, tbodyRow)

            // # dice rolled
            childGenerator("th", "# Dice rolled", theadRow)
            childGenerator("td", result["nums"].length, tbodyRow)

            // type of dice
            childGenerator("th", "Type of dice", theadRow)
            childGenerator("td", result["type"], tbodyRow)

            // roll #
            result["nums"].forEach((el, i) => {
                childGenerator("th", "Roll #" + (i + 1), theadRow)
                childGenerator("td", el, tbodyRow)
            })

            // total
            childGenerator("th", "Total", theadRow)
            childGenerator("td", result["sum"], tbodyRow)
        }

        let reset = (...elements) => {
            elements.forEach(el => el.innerHTML = "");
        }

        let childGenerator = (el, content, parent) => {
            let item = document.createElement(el)
            item.textContent = content
            parent.appendChild(item)
        }
    </script>
</body>
</html>