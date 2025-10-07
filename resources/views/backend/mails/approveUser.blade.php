<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registration Approval</title>
    </head>

    <body>
        <div id="snippetContent">
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css"> 
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> 
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

            <section class="mail-seccess section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="success-inner">
                                <h1>
                                    <img style="max-height: 100px;" src="#" alt="{{ $global_setting->title ?? '' }}">
                                    <br>
                                    <span>Registration Approval</span>
                                </h1>
                                <p>Dear Concern,</p>
                                <p>Congratulations! Your registration request approved successfully.</p>
                                <p>Thank you.</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </section>

            <style type="text/css">
                article, aside, figcaption, figure, footer, header, hgroup, main, nav, section {
                    display: block;
                }
                #snippetContent{
                    margin-top: 20px;
                }
                .container {
                    width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                    margin-right: auto;
                    margin-left: auto;
                    max-width: 1140px;
                }
                .row {
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
                    margin-right: -15px;
                    margin-left: -15px;
                }
                .offset-lg-3 {
                    margin-left: 25%;
                }
                .col-lg-6 {
                    -ms-flex: 0 0 50%;
                    flex: 0 0 50%;
                    max-width: 50%;
                }
                .col-12 {
                    -ms-flex: 0 0 100%;
                    flex: 0 0 100%;
                    max-width: 100%;
                }
                .btn:not(:disabled):not(.disabled) {
                    cursor: pointer;
                }
                .btn-group-lg>.btn, .btn-lg {
                    padding: 0.5rem 1rem;
                    font-size: 1.25rem;
                    line-height: 1.5;
                    border-radius: 0.3rem;
                }
                .btn-primary {
                    color: #fff !important;
                    background-color: #007bff !important;
                    border-color: #007bff !important;
                }
                .btn {
                    display: inline-block;
                    font-weight: 400;
                    color: #212529;
                    text-align: center;
                    vertical-align: middle;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    background-color: transparent;
                    border: 1px solid transparent;
                    padding: 0.375rem 0.75rem;
                    font-size: 1rem;
                    line-height: 1.5;
                    border-radius: 0.25rem;
                    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                    background-color: transparent;
                }
                .mail-seccess {
                    text-align: center;
                    background: #fff;
                    border-top: 1px solid #eee;
                }
                .mail-seccess .success-inner {
                    display: inline-block;
                }
                .mail-seccess .success-inner h1 {
                    font-size: 100px;
                    text-shadow: 3px 5px 2px #3333;
                    color: #006DFE;
                    font-weight: 700;
                }
                .mail-seccess .success-inner h1 span {
                    display: block;
                    font-size: 25px;
                    color: #333;
                    font-weight: 600;
                    text-shadow: none;
                    margin-top: 20px;
                }
                .mail-seccess .success-inner p {
                    padding: 20px 15px;
                }
                .mail-seccess .success-inner .btn{
                    color:#fff;
                }
            </style> 
            
        </div>
    </body>
</html>