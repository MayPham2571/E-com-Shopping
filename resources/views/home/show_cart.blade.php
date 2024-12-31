<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />


      <style type="text/css">

      .center{
        margin: auto;
        display: block;
        width: 70%;
        text-align: center;
        padding: 30px;
      }

      table, th, td{
        border: solid black 2px;
      }

      th{
        font-size: 30px;
        padding: 5px;
        background: skyblue;
      }

      .img_size{
            object-fit: contain;
            width: 100px;
            height: 100px; 
        }

        .total_des{
            font-size: 20px;
            padding: 40px;
        }
        
        .position{
            display: block; 
            position:fixed; 
            bottom:0; 
            left:0; 
            width: 100%;
        }

        table { counter-reset: li; }
        table li::before 
        {
            counter-increment: li;
            content: counter(li) ". ";
            text-align: center;
        }
        ol { 
            list-style: none;
            text-align: center;
            padding-left: 0;
         }
    
    </style>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
      </div>
      <!-- why section -->
      
        @if(@session()-> has('message'))

            <div class="alert alert-success">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}

            </div>
        @endif

      <div class="center">

        <table style="margin-left: auto; margin-right: auto;">

            <tr>
                <th>No.</th>
                <th>Product title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php $totalprice=0; ?>

            @foreach($cart as $cart)

            <tr>
                <td>
                    <ol>
                        <li></li>
                    </ol>
                </td>
                <td>{{ $cart->product_title }}</td>
                <td>{{ $cart->quantity }}</td>
                <td>
                    <?php 
                        echo number_format(" $cart->price", 0, '.', ',');
                        ?>
                    VND
                
                </td>
                <td>
                    <img class="img_size" src="/product/{{ $cart->image }}" alt="">
                </td>
                <td><a class="btn btn-danger" onclick="return confirm('Are you sure to remove this item?')" href="{{ url('remove_cart', $cart->id) }}">Remove Product</a></td>

            </tr>

            <?php $totalprice=$totalprice + $cart->price ?>

            @endforeach

        </table>

        <div>
            <h2 class="total_des">Total price: 
                <?php 
                echo number_format("$totalprice", 0, '.', ',');
                ?> VND</h2>
        </div>

        <div>
            <h1 class="" style="font-size: 25px; padding-bottom: 15px;">Choose Payment Method:</h1>

            <a href="{{ url('cash_order') }}" class="btn btn-primary">Cash On Delivery</a>
            <a href="{{ url('stripe', $totalprice) }}" class="btn btn-primary">Pay Using Card</a>
            <a href="" class="btn btn-primary">Paypal</a>
        </div>
      </div>



      
      <!-- footer end -->
      <footer class="cpy_ position">
         <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </footer>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>