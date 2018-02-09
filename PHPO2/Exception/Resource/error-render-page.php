<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHPO2 Framework Debugger</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 84.1vh;
            }

            .flex-center {
                align-items: center;
                top: 200px;
            }

            .position-ref {
                position: relative;
            }

            .top-left {
                position: absolute;
                left: 60px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-t-md {
                margin-top: 30px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .header {
                width: 100%;
                height: 12%;
            }

            .bg-color {
                background-color: #c23616;
                color: #fff;
            }

            .messages {
                position: absolute;
                left: 60px;
            }

            .code-trace {
                width: 91%;
                border: 1px solid #9c9c9c;
                left: 60px;
                position: relative;
            }

            code {
                position: relative;
                left: -350px;
            }

            .footer {
              position: absolute;
              right: 0;
              bottom: 0;
              left: 0;
              text-align: center;
              font-weight: bold;
            }
        </style>
    </head>
    <body>
        <header class="header bg-color">
            <div class="header-content top-left">
                <h2>Exception Message: <?php echo $exceptionArray['message'] ?></h2>
            </div>
        </header>
        <div class="messages">
            <div class="m-t-md">
                <h3>Uncaught exception: <?php echo $exceptionArray['class'] ?></h3>
                <h3>Thrown in <?php echo $exceptionArray['throw'] ?></h3>
                    <h3>Line number: <?php echo $exceptionArray['line'] ?></h3>
            </div>
                <h3>Stack trace:</h3>
        </div>
        <div class="flex-center position-ref">
            
            <div class="code-trace">
                <pre>
                    <code>
                      <?php foreach (array_filter($exceptionArray['trace']) as $trace): ?>
                          <?php echo '#' . $trace ?>
                      <?php endforeach ?>
                    </code>
                </pre>
            </div>
        </div>
        <footer class="footer bg-color">
            <div class="footer-content content">
                <p>PHPO2 Framework Debugger</p>
            </div>
        </footer>
    </body>
</html>
