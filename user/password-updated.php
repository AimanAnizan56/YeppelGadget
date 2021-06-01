<?php
if(isset($_POST['confirm'])):
    // update success
    if(isset($updated) and $updated):
        $updated = false;
        unset($_POST);
        ?>
            <!-- Modal popup -->
            <style>
                .modal{
                    width: 20vw!important;
                    padding: 0 10px;
                }
            </style>
            <div id="success" class="modal">
                <div class="modal-content center-align">
                    <i class="material-icons tick green-text">check_circle</i>
                </div>
                <div class="modal-footer text-center">
                    Password Updated
                </div>
            </div>
            
            <script>
                $(()=>{
                    /* Set transition duration in out popup */
                    $("#success").modal({
                        inDuration: 500,
                        outDuration: 500,
                        endingTop: "20%"
                    });
                    /* Open popup */
                    $("#success").modal("open");
                    /* Close popup after 2 second */
                    setTimeout(()=>{
                        $("#success").modal("close");
                    },2000)
                })
            </script>
        <?php
    endif;
    // update failed
    if(isset($error) and $error):
        $error = false;
        unset($_POST);
        ?>
            <style>
                .modal{
                    width: 20vw!important;
                    padding: 0 10px;
                }
            </style>
            <!-- Modal popup -->
            <div id="error" class="modal">
                <div class="modal-content center-align">
                    <i class="material-icons tick red-text">error</i>
                </div>
                <div class="modal-footer text-center">
                    Password False
                </div>
            </div>
            
            <script>
                $(()=>{
                    /* Set transition duration in out popup */
                    $("#error").modal({
                        inDuration: 500,
                        outDuration: 500,
                        endingTop: "20%"
                    });
                    /* Open popup */
                    $("#error").modal("open");
                    /* Close popup after 2 second */
                    setTimeout(()=>{
                        $("#error").modal("close");
                    },2000)
                })
            </script>
        <?php
    endif;
endif;
?>