<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
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
          --blue: royalblue;
          --white: #fff;
          --gray: #f5f5f5;
          --black1: #222;
          --black2: #999;
        }

        body {
          min-height: 100vh;
          overflow-x: hidden;
        }

        .container {
          position: relative;
          width: 100%;
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


        /* ======================= Cards ====================== */
        .cardBox {
          position: relative;
          width: 100%;
          padding: 20px;
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          grid-gap: 30px;
        }

        .cardBox .card {
          position: relative;
          background: var(--white);
          padding: 30px;
          border-radius: 20px;
          display: flex;
          justify-content: space-between;
          cursor: pointer;
          box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        }

        .cardBox .card .numbers {
          position: relative;
          font-weight: 700;
          font-size: 1.5rem;
          color: var(--blue);
        }

        .cardBox .card .cardName {
          color: var(--black2);
          font-size: 1.1rem;
          margin-top: 5px;
        }

        .cardBox .card .iconBx {
          font-size: 2.5rem;
          color: var(--black2);
        }

        .cardBox .card:hover {
          background: var(--blue);
        }
        .cardBox .card:hover .numbers,
        .cardBox .card:hover .cardName,
        .cardBox .card:hover .iconBx {
          color: var(--white);
        }

        /* ================== Order Details List ============== */
        .details {
          position: relative;
          width: 100%;
          padding: 20px;
          display: grid;
          grid-template-columns: 2fr 1fr;
          grid-gap: 30px;
          /* margin-top: 10px; */
        }


        .details .recentOrders {
          position: relative;
          display: grid;
          min-height: 500px;
          background: var(--white);
          padding: 20px;
          box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
          border-radius: 20px;
        }
        .details .cardHeader {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
        }
        .cardHeader h2 {
          font-weight: 600;
          color: var(--blue);
        }
        .cardHeader .btn {
          position: relative;
          padding: 5px 10px;
          background: var(--blue);
          text-decoration: none;
          color: var(--white);
          border-radius: 6px;
        }
        .details table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 10px;
        }
        /* ===========To Bold the head coloum============= */
        .details table thead td {
          font-weight: 600;
        }
        /* =======End====== */
        .details .recentOrders table tr {
          color: var(--black1);
          border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        .details .recentOrders table tr:last-child {
          border-bottom: none;
        }
        .details .recentOrders table tbody tr:hover {
          background: var(--blue);
          color: var(--white);
        }
        .details .recentOrders table tr td {
          padding: 10px;
        }
        .details .recentOrders table tr td:last-child {
          text-align: end;
        }
        .details .recentOrders table tr td:nth-child(2) {
          text-align: end;
        }
        .details .recentOrders table tr td:nth-child(3) {
          text-align: center;
        }
        .status.delivered {
          padding: 2px 4px;
          background: #8de02c;
          color: var(--white);
          border-radius: 4px;
          font-size: 14px;
          font-weight: 500;
        }
        .status.pending {
          padding: 2px 4px;
          background: #e9b10a;
          color: var(--white);
          border-radius: 4px;
          font-size: 14px;
          font-weight: 500;
        }
        .status.return {
          padding: 2px 4px;
          background: #f00;
          color: var(--white);
          border-radius: 4px;
          font-size: 14px;
          font-weight: 500;
        }
        .status.inProgress {
          padding: 2px 4px;
          background: #1795ce;
          color: var(--white);
          border-radius: 4px;
          font-size: 14px;
          font-weight: 500;
        }

        .recentCustomers {
          position: relative;
          /* display: grid; */
          min-height:100vh;
          padding: 20px;
          background: var(--white);
          box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
          border-radius: 20px;
        }
        .recentCustomers .imgBx {
          position: relative;
          width: 40px;
          height: 40px;
          border-radius: 50px;
          overflow: hidden;
        }
        .recentCustomers .imgBx img {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
        .recentCustomers table tr td {
          padding: 12px 10px;
        }
        .recentCustomers table tr td h4 {
          font-size: 16px;
          font-weight: 500;
          line-height: 1.2rem;
        }
        .recentCustomers table tr td h4 span {
          font-size: 14px;
          color: var(--black2);
        }
        .recentCustomers table tr:hover {
          background: var(--blue);
          color: var(--white);
        }
        .recentCustomers table tr:hover td h4 span {
          color: var(--white);
        }

        /* ====================== Responsive Design ========================== */
        @media (max-width: 991px) {
          .navigation {
            left: -300px;
          }
          .navigation.active {
            width: 300px;
            left: 0;
          }
          .main {
            width: 100%;
            left: 0;
          }
          .main.active {
            left: 300px;
          }
          .cardBox {
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 768px) {
          .details {
            grid-template-columns: 1fr;
          }
          .recentOrders {
            overflow-x: auto;
          }
          .status.inProgress {
            white-space: nowrap;
          }
        }

        @media (max-width: 480px) {
          .cardBox {
            grid-template-columns: repeat(1, 1fr);
          }
          .cardHeader h2 {
            font-size: 20px;
          }
          .user {
            min-width: 40px;
          }
          .navigation {
            width: 100%;
            left: -100%;
            z-index: 1000;
          }
          .navigation.active {
            width: 100%;
            left: 0;
          }
          .toggle {
            z-index: 10001;
          }
          .main.active .toggle {
            color: #fff;
            position: fixed;
            right: 0;
            left: initial;
          }
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
                    <a href="adminDash.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="review_document.php">
                        <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Review Documents</span>
                    </a>
                </li>

                <li>
                    <a href="fetchDetail.html">
                        <span class="icon">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Fees details</span>
                    </a>
                </li>

                <li>
                    <a href="upload_form.html">
                        <span class="icon">
                        <ion-icon name="alert-outline"></ion-icon>
                        </span>
                        <span class="title">Upload Notice</span>
                    </a>
                </li>

                <li>
                    <a href="#">
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
                <h1></h1>
                </div>
            </div>  

             <!-- ======================= Cards ================== -->
             <div class="cardBox">
                <div class="card">
                    <div onclick="gotoReviewPage()">
                        <div class="numbers">Review Documents</div>
                        <div class="cardName">Documents</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="document-text-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div onclick="gotofetchStudent()">
                        <div class="numbers">Fees Details</div>
                        <div class="cardName">Check Your Fees!!!</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="newspaper-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div onclick="gotouploadnotice()">
                        <div class="numbers">Notice </div>
                        <div class="cardName">Upload the notice!!!</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="alert-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">Analytics</div>
                        <div class="cardName">Check Your Progress!!!</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="bar-chart-outline"></ion-icon>
                    </div>
                </div>
                     
            </div>

            <!-- ================ Books History Lists ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Past Reserved Books</h2>
                        <a href="#" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Book Name</td>
                                <td>Id</td>
                                <td>Serial No.</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        

                        <tbody>
                            <tr>
                                <td>Star Refrigerator</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            
                        </tbody>

                        
                    </table>
                </div>
                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Books Added</h2>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <h4>Bachelor of Science <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            
                            <td>
                                <h4>Bachelor of Arts <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            
                            <td>
                                <h4>Bachelor of Computer Science  <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            
                            <td>
                                <h4>Bachelor of Management Studies <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                           
                            <td>
                                <h4>Bachelor of Commerce <br> <span>Italy</span></h4>
                            </td>
                        </tr>
                       
                    </table>
                </div>
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