<td colspan="3">
  <?php echo __('%%id%% - %%name%% - %%description%%', array('%%id%%' => link_to($sf_guard_permission->getId(), 'sf_guard_permission_edit', $sf_guard_permission), '%%name%%' => $sf_guard_permission->getName(), '%%description%%' => $sf_guard_permission->getDescription()), 'messages') ?>
</td>
