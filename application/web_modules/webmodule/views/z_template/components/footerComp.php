<footer id="footer" class="dark border-0">
    <div class="container center">
        <div class="footer-widgets-wrap">
            <div class="row mx-auto clearfix">
                <div class="col-lg-6">
                    <div class="widget clearfix">
                        <h4>สาขาภายในคณะ</h4>
                        <div class="row">
                            <div class="col-6">
                                <h4 class="mb-0">สาขา</h4>
                                <ul class="list-unstyled footer-site-links mb-0">
                                    <?php
                                    foreach ($facultyData['majorData'] as $major) {  ?>
                                        <li><?php echo $major['majorName'] ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0">เบอร์ติดต่อ</h4>
                                <ul class="list-unstyled footer-site-links mb-0">
                                    <?php
                                    foreach ($facultyData['majorData'] as $major) {  ?>
                                        <li><?php echo $major['majorTel'] ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="widget clearfix">
                        <h4>ช่องทางการติดต่อ</h4>
                        <p class="lead"><?php echo $facultyData['facultyTel'] ?><br><?php echo $facultyData['facultyEmail'] ?></p>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div id="copyrights">
        <div class="container center clearfix">
            Copyrights &copy; 2023 All Rights Reserved by CLLI Devs.<br>
            <div class="copyright-links"><a href="#">Privacy Policy</a></div>
        </div>
    </div>

</footer>