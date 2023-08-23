<body class="stretched">

    <!-- Document Wrapper -->
    <div id="wrapper" class="clearfix">

        <!-- Load head components -->
        <?php $this->load->view('z_template/components/headComp'); ?>

    </div>

    <!-- load breadcump component -->
    <?php
    $this->load->view('z_template/components/breadCrumbComp', $Breadcrumb); ?>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row gutter-40 col-mb-80">
                    <div id="faqs" class="faqs">
                        <div class="row pb-6">
                            <img style="max-width: 800px;display:block;margin-left:auto;margin-right:auto" src="<?php echo base_url('assets/images/quality/qa_banner.svg') ?>" alt="">
                        </div>
                        <div style="display:none" class="text-center text-danger pt-5 pb-5 mt-5 mb-5">*** ไม่มีข้อมูลการประกันคุณภาพให้แสดง ***</div>
                        <div class="toggle faq faq-marketplace faq-authors">
                            <div class="toggle-header">
                                <div class="toggle-icon">
                                    <i class="toggle-closed icon-file3"></i>
                                    <i class="toggle-open icon-file3"></i>
                                </div>
                                <div class="toggle-title">
                                    <div class="row">
                                        <div class="col-10">
                                            แบบรายงานผลการดำเนินงาน ตัวบ่งชี้การประกันคุณภาพการศึกษาภายในระดับสถาบัน ปีการศึกษา 2564 </div>
                                        <div class="col-2">
                                            29 กันยายน 2565 </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toggle-content">
                                <div class="row">
                                    <div class="col-10">
                                        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; มหาวิทยาลัยมีนโยบายและพัฒนาการจัดการเรียนรู้แบบบูรณาการกับการทำงานเพื่อยกระดับคุณภาพ<br>ผู้เรียนในรูปแบบ Cooperative and Work Integrated Education : CWIE และดำเนินการทั่วทั้ง<br>องค์กรทั้งระดับหลักสูตร คณะ และมหาวิทยาลัย ควรพัฒนาระบบกลไกในการกำกับติดตาม และการ<br>ประเมินผลลัพธ์การเรียนรู้ของผู้เรียนและผลลัพธ์ที่เกิดกับภาคส่วนที่เกี่ยวข้องกับการจัดการเรียนรู้แบบ CWIE&nbsp;<br>รวมทั้งประเมินผลกระทบทั้งในระยะสั้นและระยะยาว เพื่อนำไปสู่การพัฒนาอย่างต่อเนื่องทั้งระดับหลักสูตร&nbsp;<br>คณะ และมหาวิทยาลัย</p>
                                    </div>
                                    <!-- <div class="col-2">
                                        <a target="_blank" href="<?php echo base_url('assets/files/cwie_qa_files/qa_file_1664439849.pdf') ?>"><button type="button" class="btn btn-primary">พรีวิวรายงาน</button></a>
                                    </div> -->
                                </div>
                                <div class="row pb-2">
                                    <h4>รายการหลักฐาน SAR</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                01. คำสั่งแต่งตั้งคณะกรรมการและประกาศแนวทาง CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/01. คำสั่งแต่งตั้งคณะกรรมการและประกาศแนวทาง CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                02. รายงานผลการดำเนินงาน 2564-2565 <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/02. รายงานผลการดำเนินงาน 2564-2565.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                03. ผลงานของนักศึกษา CWIE ปี พ.ศ. 2564-2565 <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/03. ผลงานของนักศึกษา CWIE ปี พ.ศ. 2564-2565.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                04. เอกสารรายงานการประชุมคณะกรรมการขับเคลื่อนยุทธศาสตร์ CRRU-CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/04. เอกสารรายงานการประชุมคณะกรรมการขับเคลื่อนยุทธศาสตร์ CRRU-CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                05. เอกสารการสำรวจข้อมูลการจัดการเรียนการสอน CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/05. เอกสารการสำรวจข้อมูลการจัดการเรียนการสอน CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                06. รายละเอียดข้อมูลการสำรวจรูปแบบ CWIE ของหน่วยงานจัดการศึกษา <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/06. รายละเอียดข้อมูลการสำรวจรูปแบบ CWIE ของหน่วยงานจัดการศึกษา.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                07. สรุปกิจกรรมกิจกรรม CRRU-CWIE DAY 2022 <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/07. สรุปกิจกรรมกิจกรรม CRRU-CWIE DAY 2022.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                08. แนวทางการดำเนินกิจกรรม CRRU–CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/08. แนวทางการดำเนินกิจกรรม CRRU–CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                09. รายงานผลการสัมมนาวิชาการ “การยกระดับคุณภาพการศึกษาด้วยรูปแบบ CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/09. รายงานผลการสัมมนาวิชาการ “การยกระดับคุณภาพการศึกษาด้วยรูปแบบ CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                10. Website CRRU-CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/10. Website CRRU-CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                11. ภาพกิจกรรม Show and Share <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/11. ภาพกิจกรรม Show and Share.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                12. ระบบและกลไกในการดำเนินงาน CRRU–CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/12. ระบบและกลไกในการดำเนินงาน CRRU–CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                13. ภาพกิจกรรมการสร้างความเข้าใจเรื่อง CWIE <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/13. ภาพกิจกรรมการสร้างความเข้าใจเรื่อง CWIE.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                14. การพัฒนาหลักสูตรปรับปรุงหลักสูตรรูปแบบ CWIE ที่ได้เชิญเครือข่าย CWIE องค์กรผู้ใช้บัณฑิตเข้ามาร่วมพัฒนาปรับปรุงหลักสูตร <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/14. การพัฒนาหลักสูตรปรับปรุงหลักสูตรรูปแบบ CWIE ที่ได้เชิญเครือข่าย CWIE องค์กรผู้ใช้บัณฑิตเข้ามาร่วมพัฒนาปรับปรุงหลักสูตร.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                15. ตัวอย่างการจัดการศึกษาในรูปแบบ CWIE บูรณาการกับการพัฒนาท้องถิ่น <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/15. ตัวอย่างการจัดการศึกษาในรูปแบบ CWIE บูรณาการกับการพัฒนาท้องถิ่น.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                16. ภาพการร่วมกิจกรรมปรับหลักสูตรให้เป็น CWIE ของประธานสาขาวิชา <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/16. ภาพการร่วมกิจกรรมปรับหลักสูตรให้เป็น CWIE ของประธานสาขาวิชา.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                17. ภาพคณะผู้บริหาร คณาจารย์ บุคลากรวิทยาลัยเชียงราย ที่เข้าศึกษาดูงานแลกเปลี่ยนองค์ความรู้เรื่อง CWIE และผลการนำไปปรับใช้ <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/17. ภาพคณะผู้บริหาร คณาจารย์ บุคลากรวิทยาลัยเชียงราย ที่เข้าศึกษาดูงานแลกเปลี่ยนองค์ความรู้เรื่อง CWIE และผลการนำไปปรับใช้.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                18. เอกสารผลงานและความภาคภูมิใจรางวัล CWIE ระดับภาคเหนือตอนบน และระดับชาติ <a target="_blank" href="<?php echo base_url() ?>assets/files/cwie_qa_files/SAR-report/18. เอกสารผลงานและความภาคภูมิใจรางวัล CWIE ระดับภาคเหนือตอนบน และระดับชาติ.pdf"><button type="button" class="btn btn-secondary float-end"><i class="fa-solid fa-eye"></i></button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
    </section>

    <!-- Load foot components -->
    <?php $this->load->view('z_template/components/footComp'); ?>

    </div>
</body>

<script>

</script>