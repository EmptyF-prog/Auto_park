<?php get_header(); ?>


  <!--MAIN BANNER AREA START -->
  <div class="page-banner-area page-contact" id="page-banner">
      <div class="overlay dark-overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
            <div class="banner-content content-padding">
              <h1 class="text-white">Давайте обсудим работу над&nbsp;вашим проектом</h1>
              <p>Напишите нам и вам ответит проектный менеджер</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--MAIN HEADER AREA END -->
    <!--  Contact START  -->
    <section class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-sm-12 col-md-12">
            <div class="mb-5">
              <h2 class="mb-2">Напишите нам</h2>
              <p>
                Обычно, мы видим заявку сразу, а перезваниваем или пишем в ответ в течение часа. Иногда ответ может
                занять до одного дня.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-7 col-sm-12">
            <form class="contact__form" method="post" action="<?php echo admin_url('admin-ajax.php')?>">
              <!-- form message -->
              <input type="hidden" name="action" value = "my_action">
              <div class="row">
                <div class="col-12">
                  <div class="alert alert-success contact__msg" style="display: none" role="alert">
                    Ваше сообщение отправлено.
                  </div>
                </div>
              </div>
              <!-- end message -->
              <div class="row">
                <div class="col-md-6 form-group">
                  <input name="name" type="text" class="form-control" placeholder="Имя" required />
                </div>
                <div class="col-md-6 form-group">
                  <input name="email" type="email" class="form-control" placeholder="Email" required />
                </div>
                <div class="col-md-12 form-group">
                  <input name="phone" type="text" class="form-control" placeholder="Телефон" required />
                </div>
                <div class="col-12 form-group">
                  <textarea name="message" class="form-control" rows="6" placeholder="Сообщение" required></textarea>
                </div>
                <div class="col-12 mt-4">
                  <input name="submit" type="submit" class="btn btn-hero btn-circled" value="Отправить" />
                </div>
              </div>
            </form>
          </div>

          <div class="col-lg-5 pl-4 mt-4 mt-lg-0">
            <h4>Адрес офиса</h4>
            <p class="mb-3">г. Речица, ул.Трифонова 70</p>
            <h4>Телефон</h4>
            <p class="mb-3">8 (02340) 9 95 18</p>
            <h4>E-Mail</h4>
            <p class="mb-3">avtopark3@gomelavto.by</p>
          </div>
        </div>
      </div>
    </section>
    <!--  CONTACT END  -->


    <?php the_content()?>






<?php get_footer(); ?>