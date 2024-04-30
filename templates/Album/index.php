<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Album[]|\Cake\Collection\CollectionInterface $album
 */
?>

<?php
$this->assign('title', __('Album'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Album')],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="d-flex ml-auto ">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control form-control-sm ',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <?= $this->Html->link(__('New Album'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0" >
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nama_album') ?></th>
                    <th><?= $this->Paginator->sort('deskripsi') ?></th>
                    <th><?= $this->Paginator->sort('tgl_dibuat') ?></th>
                    <th><?= $this->Paginator->sort('Nama') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($album as $album) : ?>
                    <tr>
                        <td><?= $this->Number->format($i++) ?></td>
                        <td><?= h($album->nama_album) ?></td>
                        <td><?= h($album->deskripsi) ?></td>
                        <td><?= h($album->tdl_dibuat->format('d-m-Y H:i:s')) ?></td>
                        <td><?= $album->has('user') ? $this->Html->link($album->user->username, ['controller' => 'User', 'action' => 'view', $album->user->id]) : '' ?></td>
                        <td class="actions">
                            <?php if ($album->user_id === $this->request->getAttribute('identity')->get('id')) : ?>
                                <?= $this->Html->link(__('View'), ['action' => 'view', $album->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $album->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $album->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $album->id)]) ?>
                            <?php else : ?>
                                <?= $this->Html->link(__('View'), ['action' => 'view', $album->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm mb-0 ml-auto">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
    <!-- /.card-footer -->
</div>