@extends('layout.layout')
@section('content')

<section id="header" class="cd-secondary-nav">
    <div class="container">
     <div class="row">
      <nav class="navbar navbar-default">
       <!-- Brand and toggle get grouped for better mobile display -->
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dropdown-thumbnail-preview">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index.html"><img src="img/1.png" alt="abc"></a>
       </div>
       <!-- Collect the nav links, forms, and other content for toggling -->
       <div class="collapse navbar-collapse" id="dropdown-thumbnail-preview">
         <ul class="nav navbar-nav">
           <li class="active"><a href="index.html" class="hvr-underline-from-center">HOME</a></li>
           <li><a href="products.html" class="hvr-underline-from-center">PRODUCTS</a></li>
           <li><a href="products-details.html" class="hvr-underline-from-center">PRODUCTS DETAILS</a></li>
           <li><a href="gallery.html" class="hvr-underline-from-center">GALLERY</a></li>
           <li><a href="contact.html" class="hvr-underline-from-center">CONTACT</a></li>
           <li class="dropdown">
           <a href="#" class="hvr-wobble-to-top-right" data-toggle="dropdown">DROPDOWN <b class="caret"></b></a>
             <ul class="dropdown-menu">
                <li><a href="gallery.html" class="hvr-underline-from-center">GALLERY</a></li>
                <li><a href="products-details.html" class="hvr-underline-from-center">PRODUCTS DETAILS</a></li>
                <li><a href="products.html" class="hvr-underline-from-center">PRODUCTS</a></li>			 
             </ul>
           </li>
         </ul>
       </div>
       <!-- /.navbar-collapse -->
   </nav>
     </div>
    </div>
   </section>	  

@endsection