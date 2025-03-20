<table class="personal-table">
    <thead>
    <tr>
        <td>Дата создания</td>
        <td>Название</td>
        <td>
            Руководитель<br>
        </td>
        <td>
            Нач.&nbsp;отдела<br>
        </td>
        <td>
            Исполнитель<br>
        </td>
    </tr>
    <thead>
    <tbody>

    <!-- ФИЛЬТР -->
    <?
    $filterHolderArr = []; // все значения статусов для checkbox'в
    $filterHolderArr = $request->get("filter_holder") ? array_merge($filterHolderArr, $request->get("filter_holder")) : $filterHolderArr;
    $filterHidden = $filterHolderArr ? '' : 'hidden';
    ?>

    <form id="filter-form" method="POST">

        <tr>
            <td><a href="#" class="filter-block-toggler">Фильтр</a></td>
            <td>&nbsp;</td>
            <td>
                <div class="filter-block <?= $filterHidden ?>">
                    <input type="checkbox" name="filter_holder[]" value="82" <?= in_array(82, $filterHolderArr) ? 'checked' : '' ?> >
                </div>
            </td>
            <td>
                <div class="filter-block <?= $filterHidden ?>">
                    <input type="checkbox" name="filter_holder[]" value="83" <?= in_array(83, $filterHolderArr) ? 'checked' : '' ?> >
                </div>
            </td>
            <td>
                <div class="filter-block <?= $filterHidden ?>">
                    <input type="checkbox" name="filter_holder[]" value="84" <?= in_array(84, $filterHolderArr) ? 'checked' : '' ?> >
                </div>
            </td>
        </tr>

        <tr class="filter-block <?= $filterHidden ?>">
            <td colspan="5">
                <div class="text-right">
                    <a href="#" id="filter-clear">Очистить</a> &nbsp; &nbsp;
                    <input type="hidden" name="filter_action" value="filter_apply"/>
                    <input type="submit" value="Применить"/>
                </div>
            </td>
        </tr>

    </form>

    <?
    while ($arItem = $rsItems->GetNext()):

        // если документ у меня (у тек. пользователя), надо исполнять
        $status = $holderNameByIdArr[$arItem['PROPERTY_HOLDER_ENUM_ID']];
        if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $holderIdByNameArr[$myGroup]) $status = 'MY';

        $iconDocCompleteLink = '';
        $iconDocLink = '';
        if ($arItem['PROPERTY_COMPLETE_VALUE'] != 'Да') {
            if ($arItem['PROPERTY_OTVET_VALUE']['TEXT']) $iconDocLink = '<a href="/personal/questions/detail/?CODE=' . $arItem['ID'] . '" title="В работе">' . $iconDoc . '</a>';
            else $iconDocLink = '<a href="/personal/questions/detail/?CODE=' . $arItem['ID'] . '"  title="Новый">' . $iconDocNew . '</a>';
        }
        else {
            $iconDocCompleteLink = '<a style="margin-left: 20px" href="/personal/questions/detail/?CODE=' . $arItem['ID'] . '" title="Выполнено">' . $iconDocComplete . '</a>';
            $status = 'COMPLETE';
        }


        ?>
        <tr class="status-<?= $status ?>">

            <td>
                <?= $arItem['DATE_CREATE'] ?>
            </td>

            <td>
                <div class="personal-table-name">
                    <a href="/personal/questions/detail/?CODE=<?= $arItem['ID'] ?>"><?= $arItem['NAME'] ?></a>
                    <?=$iconDocCompleteLink?>
                </div>
            </td>

            <td>
                <?= $arItem['PROPERTY_DIRECTOR_VALUE'] ?
                    CUser::GetByID($arItem['PROPERTY_DIRECTOR_VALUE'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arItem['PROPERTY_DIRECTOR_VALUE'])->Fetch()['NAME'] :
                    'Не&nbsp;назначен';


                ?>
                <? if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $holderIdByNameArr['DIRECTOR']): ?>
                    <br><?= $iconDocLink ?>
                <? endif ?>
            </td>

            <td>
                <?= $arItem['PROPERTY_HEAD_VALUE'] ?
                    CUser::GetByID($arItem['PROPERTY_HEAD_VALUE'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arItem['PROPERTY_HEAD_VALUE'])->Fetch()['NAME'] :
                    'Не&nbsp;назначен'
                ?>
                <? if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $holderIdByNameArr['HEAD']): ?>
                    <br><?= $iconDocLink ?>
                <? endif ?>
            </td>

            <td>
                <?= $arItem['PROPERTY_EXECUTOR_VALUE'] ?
                    CUser::GetByID($arItem['PROPERTY_EXECUTOR_VALUE'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arItem['PROPERTY_EXECUTOR_VALUE'])->Fetch()['NAME'] :
                    'Не&nbsp;назначен'
                ?>
                <? if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $holderIdByNameArr['EXECUTOR']): ?>
                    <br><?= $iconDocLink ?>
                <? endif ?>
            </td>

        </tr>
    <?
    endwhile;
    ?>
    </tbody>
</table>

