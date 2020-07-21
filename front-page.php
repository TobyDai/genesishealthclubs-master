<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Genesis Health Clubs
 */

get_header();


?>
	<div class="slider">
		<?php $slides = ghc_get_slides(); ?>
		<?php foreach ( $slides as $slide ) : ?>
			<?php ghc_the_slide_item( $slide->ID ); ?>
		<?php endforeach; ?>
	</div>

	<div class="home-form">
		<?php gravity_form( 4, true, true, false, null, true ); ?>
	</div>

	<div class="page-content">

		<nav class="icon-links">
			<a class="icon-links__item" href="/locations" title="Browse Genesis Locations">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/locations.png" alt="Locations Icon" title="Browse Genesis Locations" />
				<span>Browse Locations</span>
			</a>
			<a class="icon-links__item" href="/free-pass" title="Get a Free Pass">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/free-pass.png" alt="Free Pass Icon" title="Get a Free Pass" />
				<span>Get a Free Pass</span>
			</a>
			<a class="icon-links__item" href="/classes" title="Browse Genesis Class Schedules">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/schedules.png" alt="Schedules Icon" title="Browse Genesis Class Schedules" />
				<span>Class Schedules</span>
			</a>
			<a class="icon-links__item" href="/personal-training" title="Personal Training">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/training.png" alt="Training Icon" title="Personal Training" />
				<span>Personal Training</span>
			</a>
		</nav>

		<div class="legacy-blocks">
			<a href="http://www.genesisfoundationwichita.com" title="Genesis Foundation for Fitness and Tennis" target="_blank">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/bg-block-gfft.jpg" alt="Young Tennis Players" title="GFFT Foundation Players">

				<h4>GFFT</h4>
				<p>Genesis Foundation for Fitness & Tennis</p>
			</a>
			<a href="/ask-a-trainer" title="Ask a Trainer">
				<img src="<?php echo get_template_directory_uri(); ?>/img/legacy/bg-block-trainer.jpg" alt="Personal Training Session" title="Ask a Trainer">
				<h4>Ask a Trainer</h4>
				<p>Achieve your Fitness Goals</p>
			</a>
		</div>

		<div class="legacy-home-intro">
			<h1>Genesis Health Clubs</h1>
			<p>Genesis offers the most well rounded fitness experience in the midwest. Each gym provides cardio and weight training equipment, group fitness classes, personal trainers, yoga pilates and much more. Membership opportunities include single, couple, family and corporate. You'll find that our facilities, services and professional staff offer you everything you need to achieve your health and fitness goals.</p>
			<p>Our gyms offer a wide-range of classes including step aerobics, Zumba, cycling, to muscular strength and Group Power to kick boxing and mind-body offerings like Pilates and yoga. Check back frequently, because we update our schedule often.</p>
			<p>Take charge of your health. Team up with Genesis Health Clubs. We will listen to your needs. Give you that extra motivation. Work with you every step of the way. Our certified, highly trained staff is here for you. We will develop a lifestyle that will change your life forever.</p>
			<p><strong>Together, we can do it!</strong></p>

			<a class="button" href="/classes" title="Available Classes">Available Classes</a>
		</div>

		<div class="legacy-home-two">
			<h2>More than a Gym</h2>
			<p>For those who would like the guidance and motivation of a fitness expert, Genesis can provide you with your own personal trainer who can help guide you and teach you how to get in shape safely and effectively. Our nationally certified personal trainers genuinely care and work to help you succeed. Because you're one of a kind, your exercise plan should be too.</p>
			<p>Each club also provides specialized amenities and services including child care, tanning, basketball courts, steam rooms, tennis courts, Yoga/Pilates studios and more.</p>
			<p>Genesis Health Clubs has locations in Wichita, Hutchinson, Salina, Emporia, McPherson, Lawrence, Manhattan, Topeka, and Leavenworth, Kansas, Kansas City, Omaha and Lincoln, Nebraska, Tulsa Oklahoma, St. Joseph and Springfield, Missouri, and Des Moines, Iowa.</p>

			<a class="button" href="/personal-training" title="Personal Training">Personal Training</a>
		</div>

		<div class="legacy-home-cta" >
			<div class="legacy-home-cta__bg" style="background-image: url(https://genesishealthclubs.ictideas.com/wp-content/uploads/VidStill_013.jpg)"></div>
			<h2>Get <em>Free</em> Yoga Classes</h2>
			<p>With Your Membership</p>
			<a class="button" href="/genesis-health-club-memberships" title="View Memberships">View Memberships</a>
		</div>


	</div>
	<?php
	while ( have_posts() ) :
		the_post();

	endwhile; // End of the loop.
	?>

<?php
get_footer();
