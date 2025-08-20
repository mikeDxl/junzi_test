<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organigrama</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f9;
            padding: 20px;
        }
        .org-chart {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .org-chart ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: row;
            gap: 150px; /* Separación horizontal entre ítems */
            justify-content: center;
            align-items: center;
        }
        .org-chart li {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .org-chart li::before {
            content: '';
            position: absolute;
            width: 2px;
            background-color: #007bff;
            top: 0;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0; /* Behind the items */
        }
        .org-chart ul > li > ul {
            margin-top: 150px; /* Separación vertical entre niveles */
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 0;
            position: relative;
        }
        .org-chart ul > li > ul::before {
            content: '';
            position: absolute;
            width: 2px;
            background-color: #007bff;
            top: 0;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0; /* Behind the items */
        }
        .org-chart ul > li > ul > li::before,
        .org-chart ul > li > ul > li::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 2px;
            background-color: #007bff;
            top: 50%;
            transform: translateY(-50%);
        }
        .org-chart ul > li > ul > li::before {
            left: -20px;
        }
        .org-chart ul > li > ul > li::after {
            right: -20px;
        }
        .org-chart .item {
            text-align: center;
            border: 2px solid #007bff;
            border-radius: 10px;
            width: 120px; /* Tamaño del cuadrado */
            height: 120px; /* Tamaño del cuadrado */
            background-color: #ffffff;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        .org-chart .item .head {
            font-weight: 700;
            background-color: #007bff;
            color: #ffffff;
            border-bottom: 2px solid #0056b3;
            padding: 5px;
            font-size: 0.9rem;
            border-radius: 5px;
        }
        .org-chart .item .body {
            padding: 5px;
            font-size: 0.8rem;
            color: #333333;
        }
        .org-chart .item .footer {
            font-size: 0.7rem;
            background-color: #f1f1f1;
            border-top: 2px solid #e1e1e1;
            padding: 5px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="org-chart">
            <ul>
                <li>
                    <div class="item">
                        <div class="head">CEO</div>
                        <div class="body">Chief Executive Officer</div>
                        <div class="footer">CEO Footer</div>
                    </div>
                    <ul>
                        <li>
                            <div class="item">
                                <div class="head">Manager 1</div>
                                <div class="body">Manager 1 Body</div>
                                <div class="footer">Manager 1 Footer</div>
                            </div>
                            <ul>
                                <li>
                                    <div class="item">
                                        <div class="head">Employee 1</div>
                                        <div class="body">Employee 1 Body</div>
                                        <div class="footer">Employee 1 Footer</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item">
                                        <div class="head">Employee 2</div>
                                        <div class="body">Employee 2 Body</div>
                                        <div class="footer">Employee 2 Footer</div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="item">
                                <div class="head">Manager 2</div>
                                <div class="body">Manager 2 Body</div>
                                <div class="footer">Manager 2 Footer</div>
                            </div>
                            <ul>
                                <li>
                                    <div class="item">
                                        <div class="head">Employee 3</div>
                                        <div class="body">Employee 3 Body</div>
                                        <div class="footer">Employee 3 Footer</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item">
                                        <div class="head">Employee 4</div>
                                        <div class="body">Employee 4 Body</div>
                                        <div class="footer">Employee 4 Footer</div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
