<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bill Invoice</title>
    <style>
        body,
        table {
            font-size: 13px;
        }

        .container {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        div[_h098asdh] {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 15px;
            padding: 5px;
            border-top: 1px dotted #454545;
            border-bottom: 1px dotted #454545;
            text-align: center;
        }

        table[_a584de] {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            caption-side: bottom;
        }

        table[_a584de] thead {
            font-weight: bold;
        }

        table[_a584de] td {
            padding: 3px;
            font-size: 12px;
            border: 1px solid #ccc;
        }

        table[_t92sadbc2] {
            width: 100%;
        }

        table[_t92sadbc2] td {
            padding: 2px;
        }

        .col-xs-1 {
            flex: 0 0 auto;
            width: 8.33333333%;
        }

        .col-xs-2 {
            flex: 0 0 auto;
            width: 16.66666667%;
        }

        .col-xs-3 {
            flex: 0 0 auto;
            width: 25%;
        }

        .col-xs-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }

        .col-xs-5 {
            flex: 0 0 auto;
            width: 41.66666667%;
        }

        .col-xs-6 {
            flex: 0 0 auto;
            width: 50%;
        }

        .col-xs-7 {
            flex: 0 0 auto;
            width: 58.33333333%;
        }

        .col-xs-8 {
            flex: 0 0 auto;
            width: 66.66666667%;
        }

        .col-xs-9 {
            flex: 0 0 auto;
            width: 75%;
        }

        .col-xs-10 {
            flex: 0 0 auto;
            width: 83.33333333%;
        }

        .col-xs-11 {
            flex: 0 0 auto;
            width: 91.66666667%;
        }

        .col-xs-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        .text-right {
            text-align: right;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
        }

        table[_a284de] {
            width: 100%;
            text-align: left;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: .5px;
        }

        .client {
            padding-top: 15px;
        }

        .client p {
            margin: 0px;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: .5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <div class="row" style="text-align: center;">
                            <?php
                            $image = 'uploads/company_profile_thum/travel-mart.jpeg';
                            $img = 'data:image;base64,' . base64_encode(@file_get_contents($image));
                            $sill = 'uploads/sill.jpeg';
                            $sillImage = 'data:image;base64,' . base64_encode(@file_get_contents($sill));
                            ?>
                            <div class="col-xs-12" style="margin-bottom: 5px;">
                                <img src="<?php echo $img; ?>" alt="Logo" style="width:100%;" />
                            </div>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="invoiceContent">
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <div _h098asdh>
                                                Bill Invoice
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table _a284de>
                                                <tr>
                                                    <td width="13%"><strong>Invoice</strong></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"><?php echo $bills->invoice ?></td>
                                                    <td width="55%"></td>
                                                </tr>

                                                <tr>
                                                    <td width="13%"><strong>Date</strong></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"><?php echo $bills->date ?></td>
                                                    <td width="55%"></td>
                                                </tr>
                                            </table>
                                            <div class="client">
                                                <strong>To</strong><br>
                                                <p><?php echo $bills->Customer_Name ?></p>
                                                <p><?php echo $bills->Customer_Address ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="padding-top: 20px;">
                                        <div class="col-xs-12">
                                            <table _a584de>
                                                <thead>
                                                    <tr>
                                                        <td>SL</td>
                                                        <td>Name</td>
                                                        <td>Airline</td>
                                                        <td>Route</td>
                                                        <td>PNR NO</td>
                                                        <td>Ticket</td>
                                                        <td>Fare</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($billDetails as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $key + 1 ?></td>
                                                            <td><?php echo $value->name ?></td>
                                                            <td><?php echo $value->ProductCategory_Name ?></td>
                                                            <td><?php echo $value->Product_Name ?></td>
                                                            <td><?php echo $value->pnr_no ?></td>
                                                            <td><?php echo $value->ticket ?></td>
                                                            <td align="right"><?php echo $value->sale_rate ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $dtlCount = count($billDetails);
                                                    if ($bills->service_amount > 0) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $dtlCount + 1; ?></td>
                                                            <td style="font-weight: bold;">Service:</td>
                                                            <td colspan="4" style="text-align:left"><?php echo $bills->other_service; ?></td>
                                                            <td style="text-align:right"><?php echo $bills->service_amount; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="flex-container">
                                            <div class="col-xs-6" style="float: left;">
                                                <div style="margin-top: 10px;">
                                                    <table>
                                                        <tr>
                                                            <td><strong>Previous Due</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right"><?php echo $bills->previous_due == null ? '0.00' : $bills->previous_due  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Current Due</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right"><?php echo $bills->due == null ? '0.00' : $bills->due ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="border-bottom: 1px solid #ccc;"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total Due</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right"><?php echo number_format(($bills->previous_due + $bills->due), 2) ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="margin-top: 7px;">
                                                    <table>
                                                        <tr>
                                                            <td><strong>Date of Issue</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right;">&nbsp;<?php echo $billDetails[0]->issue_date ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Date of Travels</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right;">&nbsp;<?php echo $billDetails[0]->flight_date ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Date of Return</strong></td>
                                                            <td><strong>: </strong></td>
                                                            <td style="text-align:right;">&nbsp;<?php echo $billDetails[0]->return_date ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-xs-6" style="float: right;">
                                                <table _t92sadbc2>
                                                    <tr>
                                                        <td><strong>Tax Amount:</strong></td>
                                                        <td style="text-align:right"><?php echo array_sum(array_column($billDetails, 'tax_amount')); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Discount:</strong></td>
                                                        <td style="text-align:right"><?php echo $bills->discount ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="border-bottom: 1px solid #ccc"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Total BDT:</strong></td>
                                                        <td style="text-align:right"><?php echo $bills->total ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Paid:</strong></td>
                                                        <td style="text-align:right"><?php echo $bills->paid ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="border-bottom: 1px solid #ccc"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Due:</strong></td>
                                                        <td style="text-align:right"><?php echo $bills->due ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p><strong>In Word: </strong> <?php echo $in_word ?></p>
                                            <strong>Note: </strong>
                                            <p style="white-space: pre-line"><?php echo $bills->note ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div style="width: 100%; height: 50px;">&nbsp;</div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="row" style=" padding-top: 20px; margin-bottom:5px; padding-bottom:6px;">
            <div class="col-xs-12">
                Thank you for your kind Co-operation
            </div>
            <div class="col-xs-12" style="padding-top: 70px;padding-bottom:8px;">
                <img src="<?php echo $sillImage; ?>" width="150px" alt="Sill"/>
            </div>
            <div class="col-xs-12">
                Shahidul Islam Babu, Chief Executive Officer, Travel Mart USA.
            </div>
        </div>
        <div style="position:fixed;left:0;bottom:15px;width:100%;">
            <div class="row" style="text-align:center;">
                <div class="col-xs-12" style="font-size:14px; padding-bottom: 5px;">
                    This is a computer generated statement and dose not require any signature.
                </div>
                <div class="col-xs-12" style="border-top: 1px solid #ccc;font-size:11px;">
                    House-114, Flat-2B (2nd Floor), Road-15, Block-C, Banani, Dhaka-1212, Bangladesh, Cell: +8801833079597, +8801714092703, E-mail: travelmartusa@yahoo.com, 729, Thierlot Avenue, Floor-1, Bronx NY 10473, New York, USA, Cell: 669 265 9014, E-mail: travelmartusa@gmail.com
                </div>
            </div>
        </div>
    </div>
</body>

</html>