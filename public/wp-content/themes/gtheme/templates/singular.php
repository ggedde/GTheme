<?php
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	// if(!GBLOCKS::has_block('banner'))
	// {
	// 	get_template_part('parts/single-banner');
	// }

	?>
	
	<?php the_content(); ?>

	<div class="my-5">


  <!--Section: Content-->
  <section class="text-center dark-grey-text">

    <!-- Section heading -->
    <h3 class="font-weight-bold pb-2 mb-4">Our pricing plans</h3>
    <!-- Section description -->
    <p class="text-muted w-responsive mx-auto mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
      Fugit, error amet numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum quisquam
      eum porro a pariatur veniam.</p>

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-lg-4 col-md-12 mb-4">

        <!-- Pricing card -->
        <div class="card pricing-card">

          <!-- Price -->
          <div class="price header text-light blue rounded-top">
            <h2 class="number">10</h2>
            <div class="version">
              <h5 class="mb-0">Basic</h5>
            </div>
          </div>

          <!-- Features -->
          <div class="card-body striped mb-1">

            <ul>
              <li>
                <p class="mt-2"><i class="fas fa-check green-text pr-2"></i>20 GB Of Storage</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>2 Email Accounts</p>
              </li>
              <li>
                <p><i class="fas fa-times red-text pr-2"></i>24h Tech Support</p>
              </li>
              <li>
                <p><i class="fas fa-times red-text pr-2"></i>300 GB Bandwidth</p>
              </li>
              <li>
                <p><i class="fas fa-times red-text pr-2"></i>User Management </p>
              </li>
            </ul>
            <button class="btn btn-blue">Buy now</button>

          </div>
          <!-- Features -->

        </div>
        <!-- Pricing card -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-4 col-md-6 mb-4">

        <!-- Pricing card -->
        <div class="card pricing-card">

          <!-- Price -->
          <div class="price header text-light indigo rounded-top">
            <h2 class="number">20</h2>
            <div class="version">
              <h5 class="mb-0">Pro</h5>
            </div>
          </div>

          <!-- Features -->
          <div class="card-body striped mb-1">

            <ul>
              <li>
                <p class="mt-2"><i class="fas fa-check green-text pr-2"></i>20 GB Of Storage</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>4 Email Accounts</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>24h Tech Support</p>
              </li>
              <li>
                <p><i class="fas fa-times red-text pr-2"></i>300 GB Bandwidth</p>
              </li>
              <li>
                <p><i class="fas fa-times red-text pr-2"></i>User Management</p>
              </li>
            </ul>
            <button class="btn btn-indigo">Buy now</button>

          </div>
          <!-- Features -->

        </div>
        <!-- Pricing card -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-4 col-md-6 mb-4">

        <!-- Pricing card -->
        <div class="card pricing-card">

          <!-- Price -->
          <div class="price header text-light deep-purple rounded-top">
            <h2 class="number">30</h2>
            <div class="version">
              <h5 class="mb-0">Enterprise</h5>
            </div>
          </div>

          <!-- Features -->
          <div class="card-body striped mb-1">

            <ul>
              <li>
                <p class="mt-2"><i class="fas fa-check green-text pr-2"></i>30 GB Of Storage</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>5 Email Accounts</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>24h Tech Support</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>300 GB Bandwidth</p>
              </li>
              <li>
                <p><i class="fas fa-check green-text pr-2"></i>User Management</p>
              </li>
            </ul>
            <button class="btn btn-deep-purple">Buy now</button>

          </div>
          <!-- Features -->

        </div>
        <!-- Pricing card -->

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!--Section: Content-->


  <div class="my-5 py-5 block-bg-1">


<!--Section: Content-->
<section class="px-md-5 mx-md-5 dark-grey-text text-center">

  <!--Grid row-->
  <div class="row d-flex justify-content-center">

	<!--Grid column-->
	<div class="col-lg-8">

	  <!--Grid row-->
	  <div class="row">

		<!--First column-->
		<div class="col-md-3 col-6 mb-4">
		  <i class="fas fa-gem fa-3x blue-text"></i>
		</div>
		<!--/First column-->

		<!--Second column-->
		<div class="col-md-3 col-6 mb-4">
		  <i class="fas fa-chart-area fa-3x teal-text"></i>
		</div>
		<!--/Second column-->

		<!--Third column-->
		<div class="col-md-3 col-6 mb-4">
		  <i class="fas fa-cogs fa-3x indigo-text"></i>
		</div>
		<!--/Third column-->

		<!--Fourth column-->
		<div class="col-md-3 col-6 mb-4">
		  <i class="fas fa-cloud-upload-alt fa-3x deep-purple-text"></i>
		</div>
		<!--/Fourth column-->

	  </div>
	  <!--/Grid row-->

	  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem minima cum sapiente alias iste expedita saepe explicabo illum ab, reiciendis aliquid nulla temporibus mollitia quae beatae harum sequi quidem ad.</p>

	</div>
	<!--Grid column-->

  </div>
  <!--Grid row-->


</section>
<!--Section: Content-->


</div>

  <div class="container my-5">


  <!--Section: Content-->
  <section class="team-section text-center dark-grey-text">

    <!-- Section heading -->
    <h3 class="font-weight-bold pb-2 mb-4">Our amazing team</h3>
    <!-- Section description -->
    <p class="text-muted w-responsive mx-auto mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
      Fugit, error amet numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum quisquam
      eum porro a pariatur veniam.</p>

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="avatar mx-auto">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg" class="rounded-circle z-depth-1"
            alt="Sample avatar">
        </div>
        <h5 class="font-weight-bold mt-4 mb-3">Anna Williams</h5>
        <p class="text-uppercase blue-text"><strong>Graphic designer</strong></p>
        <p class="grey-text">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
          adipisci sed quia non numquam modi tempora eius.</p>
        <ul class="list-unstyled mb-0">
          <!-- Facebook -->
          <a class="p-2 fa-lg fb-ic">
            <i class="fab fa-facebook-f blue-text"> </i>
          </a>
          <!-- Twitter -->
          <a class="p-2 fa-lg tw-ic">
            <i class="fab fa-twitter blue-text"> </i>
          </a>
          <!-- Instagram -->
          <a class="p-2 fa-lg ins-ic">
            <i class="fab fa-instagram blue-text"> </i>
          </a>
        </ul>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="avatar mx-auto">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(3).jpg" class="rounded-circle z-depth-1"
            alt="Sample avatar">
        </div>
        <h5 class="font-weight-bold mt-4 mb-3">John Doe</h5>
        <p class="text-uppercase blue-text"><strong>Web developer</strong></p>
        <p class="grey-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem ipsa accusantium
          doloremque rem laudantium totam aperiam.</p>
        <ul class="list-unstyled mb-0">
          <!-- Facebook -->
          <a class="p-2 fa-lg fb-ic">
            <i class="fab fa-facebook-f blue-text"> </i>
          </a>
          <!-- Instagram -->
          <a class="p-2 fa-lg ins-ic">
            <i class="fab fa-instagram blue-text"> </i>
          </a>
        </ul>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="avatar mx-auto">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="rounded-circle z-depth-1"
            alt="Sample avatar">
        </div>
        <h5 class="font-weight-bold mt-4 mb-3">Maria Smith</h5>
        <p class="text-uppercase blue-text"><strong>Photographer</strong></p>
        <p class="grey-text">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
          mollit anim est fugiat nulla id eu laborum.</p>
        <ul class="list-unstyled mb-0">
          <!-- Facebook -->
          <a class="p-2 fa-lg fb-ic">
            <i class="fab fa-facebook-f blue-text"> </i>
          </a>
          <!-- Instagram -->
          <a class="p-2 fa-lg ins-ic">
            <i class="fab fa-instagram blue-text"> </i>
          </a>
          <!-- Dribbble -->
          <a class="p-2 fa-lg ins-ic">
            <i class="fab fa-dribbble blue-text"> </i>
          </a>
        </ul>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="avatar mx-auto">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(32).jpg" class="rounded-circle z-depth-1"
            alt="Sample avatar">
        </div>
        <h5 class="font-weight-bold mt-4 mb-3">Tom Adams</h5>
        <p class="text-uppercase blue-text"><strong>Backend developer</strong></p>
        <p class="grey-text">Perspiciatis repellendus ad odit consequuntur, eveniet earum nisi qui consectetur
          totam officia voluptates perferendis voluptatibus aut.</p>
        <ul class="list-unstyled mb-0">
          <!-- Facebook -->
          <a class="p-2 fa-lg fb-ic">
            <i class="fab fa-facebook-f blue-text"> </i>
          </a>
          <!-- Github -->
          <a class="p-2 fa-lg ins-ic">
            <i class="fab fa-github blue-text"> </i>
          </a>
        </ul>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!--Section: Content-->


</div>


</div>
	<?php
}}

get_footer();
