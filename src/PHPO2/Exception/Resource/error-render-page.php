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
                top: 240px;
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
                z-index: 999;
                position: relative;
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
                left: -200px;
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
                <h2> <?php echo isset($exception['type']) ? 'Fatal Error' : 'Exception Error' ?>  Message: <?php echo $exception['message'] ?></h2>
            </div>
        </header>
        <div class="messages">
            <div class="m-t-md">
                <h3>Uncaught exception: <?php echo $exception['class'] ?></h3>
                <h3>Thrown in <?php echo $exception['throw'] ?></h3>
                <h3>Error Line number: <?php echo $exception['line'] ?></h3>
                <h3>Status Code: <?php echo $exception['code'] ?></h3>
            </div>
                <h3>Stack trace:</h3>
        </div>
        <div class="flex-center position-ref">
            
            <div class="code-trace">
                <pre>
                    <?php if (isset($exception['fatal_trace'])): ?>
                        <?php foreach ($exception['fatal_trace'] as $key => $trace): ?>
                            <code>
                                <?php echo '#'.$key.' '. trim($trace) ?>
                           </code>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php foreach (array_filter($exception['trace']) as $trace): ?>
                            <code>
                                <?php echo '#' . trim($trace) ?>
                            </code>
                        <?php endforeach ?>
                    <?php endif ?>
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
