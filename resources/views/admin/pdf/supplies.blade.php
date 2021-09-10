<!DOCTYPE html>
<html>

<head>
    <title>Supplies</title>
    <style type="text/css">
    #data {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        border-collapse: collapse;
        width: 100%;
    }

    #data td,
    #data th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #data tr:nth-child(even) {
        background-color: #f4f7fc;
    }



    #data th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #f4f7fc;
        color: #111;
    }

    .main-container {
        float: none;
        position: relative;
        background-color: #fff;
        padding: 8px;
        /* border: 1px solid #ddd; */
        margin: 0 auto;
    }

    .table-container {
        width: 75%;
        display: table;
    }

    .heading-item a {
        text-align: right;
    }

    .heading {
        padding: 10px 0px;
        margin-bottom: 5px;
        border-bottom: 3px solid #ddd;
    }


    .heading p {
        font-size: 0;
    }

    .heading p span {
        width: 50%;
        display: inline-block;
    }

    .heading p span.align-right {
        text-align: right;
    }

    .intro {
        padding: 10px 0px;
    }

    .intro p {
        font-size: 16px;
        line-height: 1.5rem;
    }

    span {
        font-size: 16px;
    }

    .col-6 {
        width: 3in;
        border: 2px solid black;
        display: inline-block;

    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0px;
        font-weight: 400;
    }

    .bold {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="main-container">

        <div class="heading">
            <p>
                <span>
                    <h5>Republic of the Philippines</h5>
                    <h4 class="bold">{{Illuminate\Support\Str::upper($admin->city)}} DISASTER RISK REDUCTION AND
                        MANAGEMENT OFFICE</h4>
                    <h6>{{$admin->province}},
                        {{$admin->region}}
                    </h6>

                </span>


            </p>
        </div>
        <div class="intro">
            <p>This is a generated report from the application <b>eLIKAS</b> as of
                <u>{{ (Carbon\Carbon::now())->toDayDateTimeString();}}</u>,
                which includes necessary information about the <u>List of Supplies in {{$admin->city}} Inventory.</u>
            </p>
        </div>
        <div class="table-container">
            <table id="data">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>SUPPLY TYPE</th>
                        <th>QUANTITY</th>
                        <th>SOURCE</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($supplies as $supply)
                    <tr>
                        <td>{{ date('F j, Y', strtotime($supply->created_at)) }}</td>
                        <td>{{ $supply -> supply_type}}</td>
                        <td>{{ $supply -> quantity }}</td>
                        <td>{{ $supply -> source}}</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



</body>

</html>