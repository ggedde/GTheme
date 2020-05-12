<?php
/*
*	Template Name: Styles
*/
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	GBLOCKS::display();

	?>
	<section class="section-container">
		<div class="row section-inner">
			<div class="col p-5">
				<?php get_template_part( 'parts/styles' ); ?>
			</div>
			<div class="col p-5 rounded-lg bg-dark text-light">
				<?php get_template_part( 'parts/styles' ); ?>
			</div>
		</div>
	</section>

	<section class="container my-4">
		<div class="row">
			<div class="col">
				<div class="col bg-light p-5 border border-secondary">
					abc
				</div>
			</div>
			<div class="col">
				<div class="col bg-light p-5 border border-secondary">
					abc
				</div>
			</div>
		</div>
	</section>

	<form class="border border-light p-5">

    <p class="h4 mb-4 text-center">Sign in</p>

    <input type="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">

    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password">

    <div class="d-flex justify-content-between">
        <div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
            </div>
        </div>
        <div>
            <a href="">Forgot password?</a>
        </div>
    </div>

    <button class="btn btn-info btn-block my-4" type="submit">Sign in</button>

    <div class="text-center">
        <p>Not a member?
            <a href="">Register</a>
        </p>

        <p>or sign in with:</p>
        <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-twitter"></i>
        </a>
        <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-github"></i>
        </a>
    </div>
</form>
	<?php
}}

get_footer();
