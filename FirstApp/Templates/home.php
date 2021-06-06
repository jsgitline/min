<section class="margin-top-40">
    <div class="container">
        <?php if(isset($context['title']) && !empty($context['title'])): ?>

            <h1><?= $context['title'] ?></h1>

        <?php else: ?>

            <p>Something wrong... :-(</p>

        <?php endif; ?>
    </div>
</section>


