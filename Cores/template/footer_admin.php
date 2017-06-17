    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body font-s12">
        <div class="content-mini content-mini-full content-boxed clearfix push-15">
            <div class="pull-right">
                Crafted with <i class="fa fa-heart text-city"></i> for <a class="font-w600" target="_blank">Vathanagul Group</a>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>

                </div>
            </div>

        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="<?php echo Settings::full_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo Settings::full_url(); ?>assets/js/pages/base_tables_datatables.js"></script>
    </body>



<?php
if(isset($_GET['logout'])) {
    $_SESSION['admin_id'] = Null;
    session_unset();
    session_destroy();
    header('Location: index.php', true, 302);
    exit;
    }
?>
