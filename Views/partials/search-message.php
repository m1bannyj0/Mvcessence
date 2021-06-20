<?php if ($search): ?>
    <div class="essences-list__search-message essences-list__search-message--flex">
        Показаны результаты по запросу "<?php echo htmlspecialchars($search, ENT_QUOTES) ?>".
        <a href="/">Посмотреть всех студентов.</a>
    </div>
<?php endif; ?>

