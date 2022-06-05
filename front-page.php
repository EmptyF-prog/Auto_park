<title>Автобусный автопарк №3</title>
<?php get_header(); ?>

 <!--MAIN BANNER AREA START -->
 <div class="banner-area banner-3">
      <div class="overlay dark-overlay"></div>
      <div class="d-table">
        <div class="d-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                  <h5 class="subtitle"><?php echo get_post_meta($post -> ID, 'subtitle', true); ?></h5>
                  <h1 class="banner-title"><?php echo get_post_meta($post -> ID, 'banner-title', true)?></h1>
                  <p>
                  <?php echo get_post_meta($post -> ID, 'banner-description', true)?>
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--MAIN HEADER AREA END -->
    <section class = "section-padding">
      <div class="container">
        <?php the_content(); ?>
      </div>
    </section>
   
   

    <!--  SERVICE PARTNER START  -->
    <section id="service-head" class="bg-feature">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12 m-auto">
            <div class="section-heading text-white">
              <h4 class="section-title">Комофорт для вас, комфорт для нас</h4>
             
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  SERVICE PARTNER END  -->

    <section id="service">
      <div class="container">
        <div class="row">
        <?php		
            global $post;

            $query = new WP_Query( [
              'posts_per_page' => 6,
              'post_type'        => 'service',
            ] );

            if ( $query->have_posts() ) {
              while ( $query->have_posts() ) {
                $query->the_post();
                ?>
                <div class="col-lg-4 col-sm-6 col-md-6">
            <div class="service-box">
              <div class="service-img-icon">
                <img src="<?php echo get_the_post_thumbnail_url();?>" alt="service-icon" class="img-fluid" />
              </div>
              <div class="service-inner">
                <h4><?php the_title();?></h4>
                <p>
                <?php the_excerpt();?>
                </p>
              </div>
            </div>
          </div>
                <?php 
              }
            } else {
              // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
          
        </div>
      </div>
    </section>
    <!-- PRICE AREA START  -->
    <section id="pricing" class="section-padding bg-main">
      <div class="container">
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
        </div>
      </div>
    </section>
    <!-- PRICE AREA END  -->
          <?php echo get_template_part( 'template-parts/content', 'testimonial', ['custom_title' => 'Клиенты котрые нам доверяют', 'custom_description' => 'Отзывы клиентов и компании с которыми мы работали'])?>
    <!--  BLOG AREA START  -->
    <section id="blog" class="section-padding bg-main">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12 m-auto">
            <div class="section-heading">
              <h4 class="section-title">Журнал</h4>
              <div class="line"></div>
              <p>
                Последние новости, и интересные статьи
              </p>
            </div>
          </div>
        </div>

        <div class="row">
        <?php		
        global $post;

        $query = new WP_Query( [
          'posts_per_page' => 5,
          'post_type' => 'post'
        ] );

        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <div class="col-lg-4 col-sm-6 col-md-4">
            <div class="blog-block">
              <?php the_post_thumbnail( 'post-thumnbnail', ['class' => 'img-fluid'] )?>
              <div class="blog-text">
                <h6 class="author-name"><span>
                 <?php
                 $category = get_the_category();
                 echo $category[0] -> name;
                 ?> 
                </span><?php the_author()?></h6>
                <a href="<?php echo get_the_permalink();?>" class="h5 my-2 d-inline-block"> <?php the_title()?> </a>
                <?php the_excerpt()?>
              </div>
            </div>
          </div>
            <?php 
          }
        } else {
          // Постов не найдено
        }

        wp_reset_postdata(); // Сбрасываем $post
        ?>
        </div>
      </div>
    </section>
    <!--  BLOG AREA END  -->
    <!--  COUNTER AREA START  -->
    <section id="counter" class="section-padding">
      <div class="overlay dark-overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="counter-stat">
              <i class="icofont icofont-heart"></i>
              <span class="counter"><?php  echo get_post_meta($post -> ID,'clients',true);?></span>
              <h5>Количество клиентов</h5>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="counter-stat">
              <i class="icofont icofont-rocket"></i>
              <span class="counter"><?php  echo get_post_meta($post -> ID,'done-partners',true);?></span>
              <h5>Количество пратнеров</h5>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="counter-stat">
              <i class="icofont icofont-hand-power"></i>
              <span class="counter"><?php  echo get_post_meta($post -> ID,'team',true);?></span>
              <h5>Людей в команде</h5>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="counter-stat">
              <i class="icofont icofont-shield-alt"></i>
              <span class="counter"><?php  echo get_post_meta($post -> ID,'current-project',true);?></span>
              <h5>Заключенных договоров</h5>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  COUNTER AREA END  -->

    <?php get_footer(); ?>

 

   


