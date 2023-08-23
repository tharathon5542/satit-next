<hr>
<li class="menu">
    <a href="javascript:void(0)"><i class="fas fa-cog"></i> ตั้งค่า<i class="fa fa-angle-left float-end"></i></a>
    <ul class="sub-menu">
        <li><a href="<?php echo base_url('crud/help') ?>"><i class="fas fa-question-circle"></i> คู่มือ</a></li>
        <li><a href="<?php echo base_url('crud/profile') . $this->session->userdata('crudSessionData')['crudPermission'] ?>"><i class="fas fa-user-circle"></i> <?php echo in_array($this->session->userdata('crudSessionData')['crudPermission'], ['faculty', 'major', 'workplace']) ? 'ข้อมูลหน่วยงาน' : 'ข้อมูลส่วนตัว' ?></a></li>
        <li><a href="<?php echo base_url('crud/auth/onSignOut') ?>"><i class="fa fa-power-off"></i> ออกจากระบบ</a></li>
    </ul>
</li>