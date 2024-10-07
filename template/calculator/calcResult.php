<main id="main" class="main">
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <div class="card">
                        <div class="card-body">
                            <form action="/calc.php">
                                <input type="text" name="x1">
                                <select name="operation">
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                    <option value="/">/</option>
                                    <option value="*">*</option>
                                </select>
                                <input type="text" name="x2">
                                <input type="submit" value="Посчитать">
                            </form> 
                            <?php echo calc() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

