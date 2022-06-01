<?php get_header(); ?>

   <!--MAIN BANNER AREA START -->
   <div class="page-banner-area page-contact" id="page-banner">
      <div class="overlay dark-overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
            <div class="banner-content content-padding">
              <h1 class="text-white">Цены на услуги аренды для Юр.лиц</h1>
              <p>Подберите подходящий тариф</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--MAIN HEADER AREA END -->
      <!-- PRICE AREA START  -->
    <section id="pricing" class="section-padding bg-main">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12 m-auto">
            <div class="section-heading">
              <h4 class="section-title">Доступные тарифы для вас</h4>
              <p>Подберите тот, который подходит вам больше всего</p>
            </div>
          </div>
        </div>
        <div class="row">
        <?php		
            global $post;

            $query = new WP_Query( [
              'posts_per_page' => 6,
              'post_type'        => 'price',
              'order'          => 'ASC'
            ] );

            if ( $query->have_posts() ) {
              while ( $query->have_posts() ) {
                $query->the_post();
                ?>
                    <div class="col-lg-4 col-sm-6">

                    <div class="pricing-block">
                    <div class="price-header">
                    <i class="icofont-<?php echo get_post_meta( $post -> ID, 'price-icon', true )?>"></i>

                    <h4 class="price"><?php the_title();?><small>BYN</small></h4>
                    <h5><?php the_excerpt();?></h5>
                    </div>
                    <div class="line"></div>
                    <?php the_content();?>

                    <a href="#" class="btn btn-hero btn-circled">выбрать тариф</a>
                    </div>
                    </div>
                <?php 
              }
            } else {
              // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
      

    </section>
    <!-- PRICE AREA END  -->

   


<?php get_footer(); ?>