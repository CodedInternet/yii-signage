<?php
/**
 * Display a summery for a single Feed object
 * @var ContentController $this
 * @var Feed $data
 * @var int $index Current row count
 * @var CListView $widget
 * @var array $types content_type
 */
$types = $this->types;
?>

<div class="feedContent">
    <h3><a href="<?php echo $this->createUrl("content/{$data->idfeed}"); ?>"><?php echo $data->feedname; ?></a></h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo Yii::t('signage', 'content_type'); ?></th>
            <th><?php echo Yii::t('signage', 'content_count_active'); ?></th>
            <th><?php echo Yii::t('signage', 'content_count_waiting'); ?></th>
            <th><?php echo Yii::t('signage', 'content_count_expired'); ?></th>
            <th class="link"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($types as $key => $type): ?>
            <tr class="<?php echo $key % 2 ? 'even' : 'odd'; ?>">
                <td><?php echo Yii::t('signage', "content_$type"); ?></td>
                <td><?php echo Content::model()->count('`idfeed`=:idfeed AND `content_type`=:type AND `start`<=:date AND `end`>=:date', array(
                        ':idfeed' => $data->idfeed,
                        ':type' => $type,
                        ':date' => date('Y-m-d'),
                    )); ?></td>
                <td><?php echo Content::model()->count('`idfeed`=:idfeed AND `content_type`=:type AND `start`>:date', array(
                        ':idfeed' => $data->idfeed,
                        ':type' => $type,
                        ':date' => date('Y-m-d'),
                    )); ?></td>
                <td><?php echo Content::model()->count('`idfeed`=:idfeed AND `content_type`=:type AND `end`<:date', array(
                        ':idfeed' => $data->idfeed,
                        ':type' => $type,
                        ':date' => date('Y-m-d'),
                    )); ?></td>
                <td>
                    <a href="<?php echo $this->createUrl("content/{$data->idfeed}", array('type' => $type)); ?>"
                       class="btn pull-right"><?php echo Yii::t('signage', 'browsecontent'); ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>