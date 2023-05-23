<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <style>
        body{
            padding: 20px!important;
        }
        body, table{
            font-size: 13px;
        }
        table th{
            text-align: center;
        }
    </style>
</head>
<body>
    <?php 
        $branchId = $this->session->userdata('BRANCHid');
        $companyInfo = $this->Billing_model->company_branch_profile($branchId);
    ?>
    <div class="container">
        <div class="row">
            <!-- <div class="col-xs-2"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $companyInfo->Company_Logo_org; ?>" alt="Logo" style="height:80px;" /></div>
            <div class="col-xs-10" style="padding-top:20px;">
                <strong style="font-size:18px;"><?php echo $companyInfo->Company_Name; ?></strong><br>
                <p style="white-space: pre-line;"><?php echo $companyInfo->Repot_Heading; ?></p>
            </div> -->
            <div class="col-xs-12" style="margin-bottom: 5px;">
                <img src="/uploads/company_profile_thum/travel-mart.jpeg" alt="Logo" style="width:100%;height:100px;" />
            </div>

            <div style="position:fixed;left:0;bottom:15px;width:100%;">
                <div class="row" style="text-align:center;">
                    <div class="col-xs-12"  style="font-size:14px; padding-bottom: 5px;">
                        This is a computer generated statement and dose not require any signature.
                    </div>
                    <div class="col-xs-12" style="border-top: 1px solid #ccc;font-size:11px;">
                    House-114, Flat-2B (2nd Floor), Road-15, Block-C, Banani, Dhaka-1212, Bangladesh, Cell: +8801833079597, +8801714092703, E-mail: travelmartusa@yahoo.com, 729, Thierlot Avenue, Floor-1, Bronx NY 10473, New York, USA, Cell: 669 265 9014, E-mail: travelmartusa@gmail.com
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>