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
		<div class="slider__item">
			<a href="">
				<img src="https://www.genesishealthclubs.com/media/slider/websiteslidersmar20201900x7003.jpg">
			</a>
		</div>
	</div>

	<nav>
		<a>Browse Locations</a>
		<a>Get a Free Pass</a>
		<a>Class Schedules</a>
		<a>Personal Training</a>
	</nav>

	<a>
		<h4>GFFT</h4>
		<p>Genesis Foundation for Fitness & Tennis</p>
	</a>
	<a>
		<h4>Ask a Trainer</h4>
		<p>Achieve your Fitness Goals</p>
	</a>

	<div>
		<h1>Genesis Health Clubs</h1>
		<p>Genesis offers the most well rounded fitness experience in the midwest. Each gym provides cardio and weight training equipment, group fitness classes, personal trainers, yoga pilates and much more. Membership opportunities include single, couple, family and corporate. You'll find that our facilities, services and professional staff offer you everything you need to achieve your health and fitness goals.</p>
		<p>Our gyms offer a wide-range of classes including step aerobics, Zumba, cycling, to muscular strength and Group Power to kick boxing and mind-body offerings like Pilates and yoga. Check back frequently, because we update our schedule often.</p>
		<p>Take charge of your health. Team up with Genesis Health Clubs. We will listen to your needs. Give you that extra motivation. Work with you every step of the way. Our certified, highly trained staff is here for you. We will develop a lifestyle that will change your life forever. Together, we can do it!</p>

		<a class="button" href="/classes">Available Classes</a>
	</div>

	<div>
		<h2>More than a Gym</h2>
		<p>For those who would like the guidance and motivation of a fitness expert, Genesis can provide you with your own personal trainer who can help guide you and teach you how to get in shape safely and effectively. Our nationally certified personal trainers genuinely care and work to help you succeed. Because you're one of a kind, your exercise plan should be too.</p>
		<p>Each club also provides specialized amenities and services including child care, tanning, basketball courts, steam rooms, tennis courts, Yoga/Pilates studios and more.</p>
		<p>Genesis Health Clubs has locations in Wichita, Hutchinson, Salina, Emporia, McPherson, Lawrence, Manhattan, Topeka, and Leavenworth, Kansas, Kansas City, Omaha and Lincoln, Nebraska, Tulsa Oklahoma, St. Joseph and Springfield, Missouri, and Des Moines, Iowa.</p>

		<a class="button">Personal Training</a>
	</div>
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.
	?>

<?php
get_footer();
