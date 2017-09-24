(function($) {


	//User Accounts Modal
    $.extend({
       UserAccountsModal: function (options) {

			var that = this;
			var User = {};
			var Users = [];
			var _defaults = {

				onUserSelect:function() { },
				closeOnUserSelect:false

			};

			that.opts = $.extend({},_defaults,options);


			var modalHTML = '<div id="UserAccountsModal" class="modal fade" tabindex="-1" role="dialog">'+
								'<div class="modal-dialog modal-full">'+
									'<div class="modal-content">'+
											'<div class="modal-header">'+
												'<button type="button" class="close x-btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
												'<h4 class="modal-title">User Accounts <small><span class="loader"></span></small></h4>'+
											'</div>'+
											'<div class="modal-body">'+
												'<!-- MODAL CONTENT -->'+
											'</div>'+
											'<div class="modal-footer">'+
											'<button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>'+
											'</div>'+
									'</div>'+
								'</div>'+
							'</div>';

			that.$modal;

			init();

			function init() {

				if($("#UserAccountsModal").length<=0) {

					that.$modal = $(modalHTML).appendTo('body');
					console.log("INJECT MODAL");
				}

			}


			that.open = function() {

				that.$modal.modal('show');

				loadUsers();

			}

			that.close = function() {

				that.$modal.modal('hide');
				that.$modal.find('.modal-body').html('');
			}

			function loadUsers(link) {

				that.$modal.find('span.loader').html('<i class="fa fa-refresh fa-spin fa-fw margin-bottom"></i>');

				that.$modal.find('.modal-body').css('opacity','.5');

				if(link !== undefined) {

					var url = link;

				} else {

					var url = "/admin/user-manager/accounts";

				}



				var o = {
					url:url,
					success:function(e) {

						that.$modal.find('.modal-body').html(e);

						that.$modal.find('.modal-body a').bind('click',function(e) {

							var href = $(this).attr("href");

                            if(href.length>0) {
                                loadUsers(href);
                            }

							return false;

						});
						that.$modal.find('span.loader').html('');

						that.$modal.find('.modal-body').css('opacity','1');
						that.$modal.find('a[rel=select-user]').unbind('click').bind('click',function(e) { 
                            e.preventDefault()
							that.opts.onUserSelect.call(that,$(this).data("user"));
                            if(that.opts.closeOnUserSelect) {
                                that.close();
                            }
							return false;
						});

					}

				};

				$.ajax(o);

			}

			return that;

        }
    });



})(jQuery);
