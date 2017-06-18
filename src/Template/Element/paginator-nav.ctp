<div class="paginator-nav">
	<div class="row">
		<div class="col-md-12">
			<div class="clearfix">
				<ul class="pagination">
					<?= $this->Paginator->prev() ?>
					<?= $this->Paginator->numbers() ?>
					<?= $this->Paginator->next() ?>
				</ul>
				<?= $this->Paginator->counter() ?>
			</div>
		</div>
	</div>
</div>
