<link href="<?php echo base_url('assets/backend/js/sweetalert.css'); ?>" rel="stylesheet">

<!-- bundle -->
<script src="<?php echo base_url('assets/backend/js/app.min.js'); ?>"></script>
<!-- third party js -->
<script src="<?php echo base_url('assets/backend/js/vendor/Chart.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.bootstrap4.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.keyTable.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.select.min.js'); ?>"></script>
<!-- third party js ends -->
<!-- demo app -->
<script src="<?php echo base_url('assets/backend/js/pages/demo.dashboard.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/pages/demo.datatable-init.js'); ?>"></script>
<!-- end demo js-->
<!-- custom js -->
<script src="<?php echo site_url('assets/backend/js/custom.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/backend/js/sweetalert.min.js'); ?>"></script>

<script>

$(document).on("click",".deleteUser",function(){
    if($(".Usercheckbox").is(":checked")){
    if (confirm('Are you sure. You want to delete ?')) {
        var current = $(this);
        var userId = $(this).data('id');
        var formData = new FormData();
       
        if($(".Usercheckbox").is(":checked")){
            $("[type='checkbox'][id^=UserChk_]:checked").each(function() {
                    formData.append('userId[]', $(this).val());
                });
        }else{
            formData.append('userId[]', $(this).data('id'));
        }
        
        $.ajax({
            url:'<?=base_url()?>admin/user_bulk_delete',
            type:'POST',
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',

            success:function(res){
                if(res==true){
                    $("[type='checkbox'][id^=UserChk_]:checked").each(function () {
                            $(this).closest('tr').fadeOut(function () {
                                $(this).remove();
                            });
                    });
                    current.parents('tr').remove();
                    swal("Success", "User successfully deleted", "success");

                }
            }
        });
    } else {
     
    }
    }else{
            alert("Please checked one user at least");
        }
});

$(document).on("click",".deleteSingleUser",function(){
   
    if (confirm('Are you sure. You want to delete ?')) {
        var current = $(this);
        var userId = $(this).data('id');
        var formData = new FormData();
       
        if($(".Usercheckbox").is(":checked")){
            $("[type='checkbox'][id^=UserChk_]:checked").each(function() {
                    formData.append('userId[]', $(this).val());
                });
        }else{
            formData.append('userId[]', $(this).data('id'));
        }
        
        $.ajax({
            url:'<?=base_url()?>admin/user_bulk_delete',
            type:'POST',
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',

            success:function(res){
                if(res==true){
                    $("[type='checkbox'][id^=UserChk_]:checked").each(function () {
                            $(this).closest('tr').fadeOut(function () {
                                $(this).remove();
                            });
                    });
                    current.parents('tr').remove();
                    swal("Success", "User successfully deleted", "success");

                }
            }
        });
    } else {
     
    }
    
});

    $('#UserChkAll').on('change',function(){
            $('.Usercheckbox').prop('checked',this.checked);
    });

       $('.Usercheckbox').on('change',function(){

                var current = $(this);
                var totalCheckboxes  = $('.Usercheckbox').length;
                if(current.is(":checked")){
                   if(totalCheckboxes == $('.Usercheckbox:checked').length){
                        $('#UserChkAll').prop('checked',true);
                    }
                }
                else{
                    $('#UserChkAll').prop('checked',false);
                }
            });


         $(".UpgradeMembership").on("click",function(){
            var current = $(this);
            var formData = [];
            var totalCheckboxes  = $('.Usercheckbox:checked').length;
            if($(".Usercheckbox").is(":checked")){
                
                    $("[type='checkbox'][id^=UserChk_]:checked").each(function() {
                        formData.push($(this).val());
                    });
                
            }else{
                alert("Please checked one user at least");
              //  formData.append('userId[]', $(this).data('id'));
            }
          //  console.log(totalCheckboxes);
            if(totalCheckboxes != ""){
          //      console.log(formData);
                $("#SubUserIds").val(formData);
                $("#membership").modal()
           //     console.log(formData);
            }

         });   

         $(".membership_form").on("click",".subscribeNow",function(){
 
            let plan_id = $(this).data('plan');
            let user_id = $("#SubUserIds").val();
             user_id =   user_id.toString()                                                                                                 ;
           
            $.ajax({
            url:'<?=base_url()?>admin/ugrade_membership',
            type:'POST',
            data:{'plan_id':plan_id,'user_id':user_id},
            // cache: false,
            // contentType: false,
            // processData: false,
            dataType: 'json',

            success:function(res){
                if(res==true){
                   // console.log(res);
                    // $("[type='checkbox'][id^=UserChk_]:checked").each(function () {
                    //         $(this).closest('tr').eq(3).text("gg");
                    // });
                    // current.parents('tr').remove();
                     swal("Success", "Membership successfully Upgraded", "success");
                     window.location.reload();

                }
            }
        });


         });
    $(".remove").click(function () {
                var id = $(this).parents("tr").attr("id");
                console.log(id);
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '<?=base_url() ?>admin/chashi_vendors/' + id,
                                    type: 'DELETE'

                                    error: function () {
                                        alert('Something is wrong');
                                    },
                                    success: function (data) {
                                        $("#" + id).remove();
                                        swal("Deleted!", "User has been deleted.", "success");
                                    }
                                });
                            } else {
                                swal("Cancelled", "Your imaginary file is safe :)", "error");
                            }
                        });

            });


</script>