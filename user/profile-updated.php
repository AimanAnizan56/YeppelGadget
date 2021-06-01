<?php
if(isset($updated) and $updated):
    $updated = false;
    ?>
        <style>
            .modal{
                width: 20vw!important;
                padding: 0 10px;
            }
        </style>
        <!-- Modal popup -->
        <div id="success" class="modal">
            <div class="modal-content center-align">
                <i class="material-icons tick green-text">check_circle</i>
            </div>
            <div class="modal-footer text-center">
                Profile Updated
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
?>