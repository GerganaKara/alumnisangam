<?php
// auto-generated by sfPropelCrud
// date: 2009/07/17 06:53:53
?>
<?php use_helper('Object') ?>

<?php echo form_tag('news/update') ?>

<?php echo object_input_hidden_tag($news, 'getId') ?>

<table>
<tbody>
<tr>
  <th>Name:</th>
  <td><?php echo object_input_tag($news, 'getName', array (
  'size' => 50,
)) ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($news->getId()): ?>
  &nbsp;<?php echo link_to('delete', 'news/delete?id='.$news->getId(), 'post=true&confirm=Are you sure?') ?>
  &nbsp;<?php echo link_to('cancel', 'news/show?id='.$news->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'news/list') ?>
<?php endif; ?>
</form>
