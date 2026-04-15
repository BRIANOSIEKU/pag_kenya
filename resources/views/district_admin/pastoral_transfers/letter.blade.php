<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000;
            line-height: 1.4;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .header img {
            width: 150px;
            height: auto;
        }

        .contact-info {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .office-title {
            font-style: italic;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0;
        }

        .main-title {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
            letter-spacing: 1px;
            font-family: 'Roboto', sans-serif;
font-weight: 900;
        }

        .content-body {
            margin-top: 20px;
        }

        .date-line {
            margin-bottom: 20px;
        }

        .recipient-info {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .subject {
            text-decoration: underline;
            font-weight: bold;
            margin: 20px 0;
        }

        .message {
            text-align: justify;
        }

        .message p {
            margin-bottom: 15px;
        }

        .signature-section {
            margin-top: 30px;
        }

        .closing {
            margin-bottom: 40px;
        }

        .bold {
            font-weight: bold;
        }

        /* FOOTER */
        .footer {
    position: fixed;
    bottom: 20px; /* distance from bottom of page */
    left: 0;
    right: 0;
    text-align: center;
    width: 100%;
}

.footer hr {
    border: 1px solid #00AEEF;
    margin: 0 0 10px 0;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
}

        .footer p {
            color: #00AEEF;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>

   <!-- HEADER -->
<!-- HEADER -->
<table width="100%" style="border-collapse:collapse;">
    <tr>
        <!-- LOGO LEFT -->
        <td width="20%" style="vertical-align:top;">
            <img src="{{ public_path('images/pagk_logo.png') }}" 
                 alt="PAG Logo" 
                 style="width:130px; height:auto;">
        </td>

        <!-- TEXT RIGHT -->
        <td width="80%" style="text-align:center; vertical-align:top;">

            <div class="main-title" style="font-size:18px; font-weight:bold;">
                PENTECOSTAL ASSEMBLIES OF GOD - KENYA
            </div>

            <div class="contact-info" style="margin-top:5px; font-size:10px;">
                Nyang’ori Mission Station Headquarters off Kisumu – Kakamega Highway<br>
                P.O. Box 671 – 40100, KISUMU<br>
                Mobile No. 0726 078 479 | Email: pagchurch671@gmail.com
            </div>

            <div class="office-title" style="margin-top:7px;">
                From the Desk of the General Superintendent
            </div>

        </td>
    </tr>
</table>

<hr style="border: 1px solid #00AEEF; margin-top:10px;">

<!-- BODY -->
<div class="content-body">

    <div class="date-line">
        <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('l jS F Y') }}
    </div>

    <div class="recipient-info">
        {{ $transfer->pastor->name ?? 'Pst. Silas Kipiego Rugut' }},<br>
        {{ $transfer->fromAssembly->name ?? 'Lelgol PAG Assembly' }},<br>
        {{ $transfer->fromDistrict->name ?? 'Kapsabet PAG District' }}.
    </div>

    <p>Dear Servant of God,</p>

    <div class="subject">
        RE: TRANSFER.
    </div>

    <div class="message">
        <p>Receive greetings in the Name of Our Lord Jesus Christ.</p>

        <p>
            You are hereby transferred to 
            <span class="bold">{{ $transfer->toAssembly->name ?? 'Chesuwe PAG Assembly' }}</span> 
            within 
            <span class="bold">{{ $transfer->toDistrict->name ?? 'Kapsabet PAG District' }}</span> 
            pursuant to proposals from the District office.
        </p>

        <p>
            The transfer takes effect 
            <span class="bold">{{ \Carbon\Carbon::now()->format('l jS F Y') }}</span>.
        </p>

        <p>
            I hereby wish to encourage the District Overseer(s) to be fully engaged in this process 
            in line with Article 8.7 (f) of the PAG – K Constitution (1998).
        </p>

        <p>
            I take this opportunity to wish you God’s blessings as you move to the new station.
        </p>
    </div>

    <!-- SIGNATURE -->
    <div class="signature-section">
        <p class="closing">Yours in the service of Our Lord Jesus Christ.</p>

        <p class="bold">
            FOR AND ON BEHALF OF THE EXECUTIVE POSTING COMMITTEE.
        </p>

        <div style="margin: 10px 0;">
            <img src="C:\xampp\htdocs\pag_kenya\public\images\signatures\GS.jpeg"
                 style="width: 180px; height: auto;"
                 alt="Signature">
        </div>

        <p class="bold" style="margin: 0;">Rev. Bishop Kenneth Adiara.</p>
        <p class="bold" style="margin: 0;">The General Superintendent.</p>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    <hr>
    <p>Serving the Nations with the Word.</p>
</div>

</body>
</html>