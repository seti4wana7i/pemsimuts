<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="headers.css" rel="stylesheet">
</head>

<body id="load">
    <main>

        <div class="container">
            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <!-- <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li> -->
                    <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Import excel</a></li>
                    <li class="nav-item"><a href="http://localhost/pemsimuts/Index.php?haha=close" class="nav-link">Log Out</a></li>
                </ul>
            </header>
        </div>

        </header>

        <div class="b-example-divider"></div>
    </main>

    <div class="container">
        <div class="mb-3">
            <label for="formFile" class="form-label">excel</label>
            <input class="form-control" type="file" id="excel" accept=".xls, .xlsx">
        </div>
        <div id="forInfo">

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script type="module">
        import {
            reglinear
        } from './uts.js';

        var x = [];
        var y = [];

        var dx = <?php echo json_encode($x, JSON_HEX_TAG); ?>;
        var dy = <?php echo json_encode($y, JSON_HEX_TAG); ?>;
        if (dx != null) {
            var mx = dx.map((e) => {
                return parseFloat(e)
            });

            var my = dy.map((e) => {
                return parseFloat(e)
            });
        }

        function page() {
            if (dx != null) {
                reg(mx, my);
            }
        }

        async function iexcel(e) {
            const file = e.target.files[0];
            const data = await file.arrayBuffer();
            const workbook = XLSX.read(data);

            console.log(workbook);
            const jsa = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], {
                header: 1
            });

            let dt = jsa.filter(e => e.every(item => !isNaN(item)));
            dt.forEach(e => x.push(e[0]));
            dt.forEach(e => y.push(e[1]));

            fetch('http://localhost/pemsimuts/Check.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dt),
                })
                .then(response => response.json())
                .then(dt => {
                    console.log('Success:', dt);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            console.log(x);

            reg(x, y);
        }

        function reg(x, y) {
            const reg = new reglinear(x, y);

            let xi = document.createElement('p');
            xi.innerHTML = 'sigma X = ' + reg.preCount().sum_x;
            document.getElementById('forInfo').appendChild(xi);

            let yi = document.createElement('p');
            yi.innerHTML = 'sigma Y = ' + reg.preCount().sum_y;
            document.getElementById('forInfo').appendChild(yi);

            let xi2 = document.createElement('p');
            xi2.innerHTML = 'sigma X^2 = ' + reg.preCount().sum_x_kuadrat;
            document.getElementById('forInfo').appendChild(xi2);

            let yi2 = document.createElement('p');
            yi2.innerHTML = 'sigma Y^2 = ' + reg.preCount().sum_y_kuadrat;
            document.getElementById('forInfo').appendChild(yi2);

            let xy = document.createElement('p');
            xy.innerHTML = 'sigma X*Y = ' + reg.preCount().sum_x_y;
            document.getElementById('forInfo').appendChild(xy);

            let n = document.createElement('p');
            n.innerHTML = 'jumlah baris data = ' + x.length;
            document.getElementById('forInfo').appendChild(n);

            let a = document.createElement('p');
            a.innerHTML = 'a = ' + reg.b0;
            document.getElementById('forInfo').appendChild(a);

            let b = document.createElement('p');
            b.innerHTML = 'b = ' + reg.b1;
            document.getElementById('forInfo').appendChild(b);

            let ra = document.createElement('p');
            ra.innerHTML = 'korelasi = ' + reg.preCount().r;
            document.getElementById('forInfo').appendChild(ra);


            let kd = document.createElement('p');
            kd.innerHTML = 'koefisien determinasi = ' + reg.preCount().kd;
            document.getElementById('forInfo').appendChild(kd);

            let exp = document.createElement('p');
            exp.innerHTML = 'besar kontribusi variable X dapat menjelaskan sebesar ' + reg.preCount().kd + '% dari perubahan yang ada di variabel Y. <br> sisanya sebesar ' + (100 - reg.preCount().kd) + '% dijelaskan oleh variabel selain X';
            document.getElementById('forInfo').appendChild(exp);

            var text;
            let c = reg.preCount().r;
            if (c < 0) {
                text = 'nilai korelasi (-) menunjukkan hubungan yang terbalik';
            } else {

                text = 'nilai korelasi (+) menunjukkan hubungan yang lurus/linear';
            }

            let exp2 = document.createElement('p');
            exp2.innerHTML = text;
            document.getElementById('forInfo').appendChild(exp2);

            var text2;
            if (0 <= c <= 0.2) {
                text2 = 'sangat lemah';
            } else if (0.21 <= c <= 0.4) {
                text2 = 'lemah';
            } else if (0.41 <= c <= 0.6) {
                text2 = 'sedang';
            } else if (0.61 <= c <= 0.8) {
                text2 = 'kuat';
            } else if (0.81 <= c <= 1) {
                text2 = 'sangat kuat';
            }

            let exp3 = document.createElement('p');
            exp3.innerHTML = 'besar hubungan ' + c + '--> kekuatan hubungan ' + text2;
            document.getElementById('forInfo').appendChild(exp3);

            console.log(reg.preCount());
        }

        excel.addEventListener("change", iexcel, false);
        window.addEventListener('load', page);
    </script>

</body>

</html>