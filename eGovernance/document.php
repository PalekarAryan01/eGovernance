<?php
session_start();

// Check if the user is logged in and has student status
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'student') {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* =========== Google Fonts ============ */
        @import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap");

        /* =============== Globals ============== */
        * {
          font-family: "Ubuntu", sans-serif;
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        :root {
          --blue:royalblue; ;
          --white: #fff;
          --gray: #f5f5f5;
          --black1: #222;
          --black2: #999;
        }

        body {
          min-height: 100vh;
          overflow-x: hidden;
        }

        .sub-container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0,0,1,0.9);
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            border: 3px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: royalblue;
            color: #fff;
        }
        .upload-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .upload-btn input[type="file"] {
            display: none;
        }
        .upload-btn span {
            color: #007bff;
            text-decoration: underline;
        }
        .reupload {
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .submit-btn:hover {
            background-color: royalblue;
        }
        .file-icon {
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }

        

        /* =============== Navigation ================ */
        .navigation {
            position: fixed;
            width: 300px;
            height: 100%;
            background: var(--blue);
            border-left: 10px solid var(--blue);
            transition: 0.5s;
            overflow: hidden;
          }
          .navigation.active {
            width: 80px;
          }

          .navigation ul {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
          }

          .navigation ul li {
            position: relative;
            width: 100%;
            list-style: none;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
          }

          .navigation ul li:hover,
          .navigation ul li.hovered {
            background-color: var(--white);
          }

          .navigation ul li:nth-child(1) {
            margin-bottom: 40px;
            pointer-events: none;
          }

          .navigation ul li a {
            position: relative;
            display: block;
            width: 100%;
            display: flex;
            text-decoration: none;
            color: var(--white);
          }
          .navigation ul li:hover a,
          .navigation ul li.hovered a {
            color: var(--blue);
          }

          .navigation ul li a .icon {
            position: relative;
            display: block;
            min-width: 60px;
            height: 60px;
            line-height: 75px;
            text-align: center;
          }
          .navigation ul li a .icon ion-icon {
            font-size: 1.75rem;
          }

          .navigation ul li a .title {
            position: relative;
            display: block;
            padding: 0 10px;
            height: 60px;
            line-height: 60px;
            text-align: start;
            white-space: nowrap;
          }
          .navigation ul li .title-1 {
            font-size: 20px;
            margin-top: 10px;
            position: relative;
            display: block;
            padding: 0 10px;
            height: 60px;
            line-height: 30px;
          }
      



        .navigation ul li:nth-child(9){
            position: absolute;
            margin-top: 180px;
            width: 100%;
        }
        /* --------- curve outside ---------- */
        .navigation ul li:hover a::before,
        .navigation ul li.hovered a::before {
          content: "";
          position: absolute;
          right: 0;
          top: -50px;
          width: 50px;
          height: 50px;
          background-color: transparent;
          border-radius: 50%;
          box-shadow: 35px 35px 0 10px var(--white);
          pointer-events: none;
        }
        .navigation ul li:hover a::after,
        .navigation ul li.hovered a::after {
          content: "";
          position: absolute;
          right: 0;
          bottom: -50px;
          width: 50px;
          height: 50px;
          background-color: transparent;
          border-radius: 50%;
          box-shadow: 35px -35px 0 10px var(--white);
          pointer-events: none;
        }


        /* ===================== Main ===================== */
        .main {
          position: absolute;
          width: calc(100% - 300px);
          left: 300px;
          min-height: 100vh;
          background: var(--white);
          transition: 0.5s;
        }
        .main.active {
          width: calc(100% - 80px);
          left: 80px;
        }

        .topbar {
          width: 100%;
          height: 60px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 0 10px;
        }

        .toggle {
          position: relative;
          width: 60px;
          height: 60px;
          display: flex;
          justify-content: center;
          align-items: center;
          font-size: 2.5rem;
          cursor: pointer;
        }

        .search {
          position: relative;
          width: 400px;
          margin: 0 10px;
        }

        .search label {
          position: relative;
          width: 100%;
        }

        .search label input {
          width: 100%;
          height: 40px;
          border-radius: 40px;
          padding: 5px 20px;
          padding-left: 35px;
          font-size: 18px;
          outline: none;
          border: 1px solid var(--black2);
        }

        .search label ion-icon {
          position: absolute;
          top: 0;
          left: 10px;
          font-size: 1.2rem;
        }

        .user{
        
          width: 250px;
          height: 60px;
          align-items: center;
          overflow: hidden;
          cursor: pointer;
          padding-top: 10px;
        }
        .user h1{
          font-weight:700;
          font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
          font-size:30px;
          color:royalblue;
          text-align: center;
        
        }


        
</style>
</head>
<body>
     <!-- =============== Navigation ================ -->
     <div class="container">
        <div class="navigation">
            <ul>
                
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="ribbon"></ion-icon>
                        </span>
                        <span class="title-1">Nirmala Memorial Foundation College </span>
                    </a>
                    
                </li>

                <li>
                    <a href="studDash.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="document.php">
                        <span class="icon">
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        </span>
                        <span class="title">Upload Documents</span>
                    </a>
                </li>

                <li>
                    <a href="disBook.php">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Books</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="git-pull-request-outline"></ion-icon>
                        </span>
                        <span class="title">Borrower</span>
                    </a>
                </li> -->

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Help</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title" name="logout" >Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
         <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user" onclick="gotoEditPage()">
                <h1> </h1>
                </div>
            </div>  

            <div class="sub-container">
        <div class="header">
            <h1>Documents Submission for Admission</h1>
        </div>
        <form id="admissionForm" enctype="multipart/form-data">
            <table>
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>List of Documents</th>
                        <th>Upload Document</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>10th Marksheet (PDF)</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>12th Marksheet (PDF)</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Passport size photo </td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Aadhar card</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Caste certificate</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Leaving Certificate</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>Signature</td>
                        <td>
                            <div class="upload-btn">
                                <img src="/images/document-logo.jpg" alt="File Icon" class="file-icon">
                                <label>
                                    <span id="label-marksheet10">Choose File</span>
                                    <input type="file" id="marksheet10" name="marksheet10" accept="application/pdf, application/document, image/png, image/jpeg ,image/jpg" onchange="handleFileUpload(event, 'marksheet10')">
                                </label>
                            </div>
                        </td>
                    </tr>

                    
                </tbody>
            </table>
            <button type="button" class="submit-btn" onclick="validateForm()">Submit</button>
        </form>
    </div>

            

            
            
                
            
        </div>
    </div>

<script src="js/dashboard.js"></script>
     <!-- ====== ionicons ======= -->
     <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
     <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
 </body>
</body>
</html>