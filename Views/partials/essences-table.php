<?php use EssenceList\Helpers\{UrlManager, Util}; ?>
<table class="uk-table uk-table-small uk-table-hover uk-table-divider essences-table">
    <thead>
        <tr>
            <th class="uk-text-center"><?php
                Util::showSortingArrow("name", $order, $direction)
                ?><a href="?<?php echo htmlspecialchars(UrlManager::getSortingLink(
                    $page,
                    "name",
                    $order,
                    $direction,
                    $search
                ), ENT_QUOTES); ?>">Имя</a></th>
            <th class="uk-text-center"><?php
                Util::showSortingArrow("surname", $order, $direction)
                ?><a href="?<?php echo htmlspecialchars(UrlManager::getSortingLink(
                    $page,
                    "surname",
                    $order,
                    $direction,
                    $search
                ), ENT_QUOTES); ?>">Фамилия</a></th>
            <th class="uk-text-center"><?php
                Util::showSortingArrow("group_number", $order, $direction)
                ?><a href="?<?php echo htmlspecialchars(UrlManager::getSortingLink(
                    $page,
                    "group_number",
                    $order,
                    $direction,
                    $search
                ), ENT_QUOTES); ?>">Номер группы</a></th>
            <th class="uk-text-center"><?php
                Util::showSortingArrow("exam_score", $order, $direction)
                ?><a href="?<?php echo htmlspecialchars(UrlManager::getSortingLink(
                    $page,
                    "exam_score",
                    $order,
                    $direction,
                    $search
                ), ENT_QUOTES); ?>">Баллы ЕГЭ</a></th>
        </tr>
        </thead>
    <tbody>
        <?php foreach($essences as $essence): ?>
            <tr class="uk-text-center">
                <td><?php echo htmlspecialchars($essence["name"], ENT_QUOTES) ?></td>
                <td><?php echo htmlspecialchars($essence["surname"], ENT_QUOTES) ?></td>
                <td><?php echo htmlspecialchars($essence["group_number"], ENT_QUOTES) ?></td>
                <td><?php echo htmlspecialchars($essence["exam_score"], ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


