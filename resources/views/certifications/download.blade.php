<html>
<head>
    <style>
        @page {
            size: 330mm 210mm; /* Set the page size to F4 landscape */
            margin: 0; /* Remove default margins */
        }

        body { 
            font-family: 'Helvetica', sans-serif; 
            margin: 0; 
            padding: 0; 
            width: 330mm; /* Set body width to F4 landscape size */
            height: 210mm; /* Set body height to F4 landscape size */
        }

        .container { 
            padding: 0; /* Remove padding for full width */
            width: 100%; 
            height: 100%; /* Ensure the container takes full height */
            margin: auto; 
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
        }

        .certificate {
            background: url('{{ public_path('assets/img/SERTIF.png') }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 20px; /* Reduced padding for better fit */
            text-align: center;
            height: 100%; /* Ensure the certificate takes the full height */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
        }

        h2 { 
            font-size: 3.5rem; /* Increased font size */
            color: #2c3e50; 
            margin: 5px 0; /* Reduced margins */
        }

        h1 { 
            font-size: 3rem; /* Increased font size */
            color: #007bff; 
            border-bottom: 2px solid #2c3e50; 
            display: inline-block; 
            width: 70%; 
            padding-bottom: 5px; 
            margin: 5px 0; /* Reduced margins */
        }

        h3 { 
            font-size: 2rem; /* Increased font size */
            color: #6c757d; 
            margin: 5px 0; /* Reduced margins */
        }

        .text-muted { 
            color: #6c757d; 
            font-size: 1rem; /* Slightly adjusted size */
        }

        .fw-bold { 
            font-weight: bold; 
        }

        .signature {
            margin-top: 40px; /* Increased spacing above the signature section */
            display: flex;
            justify-content: space-between; /* Adjusted spacing for better layout */
            align-items: flex-end; /* Align items to the bottom */
            padding: 0 20px; /* Added padding to left and right */
        }

        .signature img { 
            width: 100px; /* Adjusted width for signature */
            height: auto; 
        }

        .signature .col { 
            text-align: center; /* Center the text */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate">
            <h2 class="text-uppercase fw-bold text-center mb-0">Certificate of Completion</h2>
            <p class="text-muted fst-italic text-center mb-3">This certifies that</p>

            <!-- Recipient Name -->
            <h1 class="display-4 fw-bold text-center text-primary">
                <span style="border-bottom: 2px solid #2c3e50; padding-bottom: 5px; display: inline-block; width: 80%;"> 
                    {{ $certification->user->name }}
                </span>
            </h1>

            <!-- Achievement Section -->
            <p class="mt-3 text-muted text-center">
                Has successfully completed the course:
            </p>
            <h3 class="fw-bold mb-3 text-center text-secondary">{{ $certification->course->name ?? 'No Course' }}</h3>

            <!-- Date and Signature Row -->
            <div class="signature">
                <!-- Date Column -->
                <div class="col">
                    <p class="text-muted">Awarded on</p>
                    <p class="fw-bold">{{ $formattedDate }}</p>
                </div>

                <!-- Signature Column -->
                <div class="col">
                    <p class="text-muted">Signature</p>
                    <img src="{{ public_path('assets/img/TTD.png') }}" alt="Signature">
                    <p class="mt-1 text-muted">[I Nengah Laba]</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
