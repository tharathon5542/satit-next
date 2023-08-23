<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Load head component
		============================================= -->
        <?php $this->load->view('z_template/components/headComp'); ?>

        <!-- Load Banner slider component
		============================================= -->
        <?php
        $bannerData ? $this->load->view('z_template/components/bannerComp2', $bannerData) : null;
        ?>

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="promo promo-light promo-full promo-uppercase p-5 bottommargin-lg header-stick">
                    <div class="container clearfix">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg">
                                <h3 style="letter-spacing: 2px;">สหกิจศึกษาและการศึกษาเชิงบูรณาการกับการทำงาน</h3>
                                <span>Cooperative and Work Integrated Education : CWIE</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container clearfix">

                    <div class="row col-mb-50">
                        <div class="fancy-title title-bottom-border">
                            <h3><i class="icon-megaphone"></i> ข่าวประชาสัมพันธ์</h3>
                        </div>
                        <!-- load news component -->
                        <?php $this->load->view('z_template/components/newsComp', $newsData); ?>
                    </div>

                    <div class="line"></div>

                    <div class="row col-mb-50">
                        <div class="fancy-title title-bottom-border">
                            <h3><i class="icon-calendar2"></i> ปฏิทินกิจกรรม</h3>
                        </div>
                        <!-- load calendar component -->
                        <div class="d-flex justify-content-center">
                            <?php $this->load->view('z_template/components/calendarComp'); ?>
                        </div>
                    </div>

                    <div class="line"></div>

                    <div class="row col-mb-50">
                        <div class="col-12">
                            <div class="fancy-title title-bottom-border">
                                <h3><i class="icon-images"></i> รูปภาพกิจกรรม</h3>
                            </div>
                            <!-- load news / event images component -->
                            <?php $this->load->view('z_template/components/imageGalleryComp', $imagesGalleryData); ?>
                        </div>
                    </div>

                    <div class="line"></div>

                    <div id="facultyList" class="row col-mb-50">
                        <div class="fancy-title title-bottom-border">
                            <h3><i class="icon-group"></i> หน่วยงานจัดการศึกษาภายใน มร.ชร.</h3>
                        </div>
                        <ul class="clients-grid grid-2 grid-sm-3 grid-md-4 grid-lg-5 mb-0">
                            <?php foreach ($facultyData as $faculty) { ?>
                                <li class="grid-item">
                                    <img src="<?php echo base_url('assets/images/profile/' . $faculty['facultyImage']) ?>" alt="faculty logo">
                                    <div class="bg-overlay">
                                        <div class="bg-overlay-content flex-column" data-hover-animate="fadeIn">
                                            <div class="portfolio-desc p-0 center" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350">
                                                <h3><a target="_blank" href="<?php echo base_url('faculty/' . $faculty['facultyWebsite']) ?>"><?php echo $faculty['facultyNameTH'] ?></a></h3>
                                            </div>
                                        </div>
                                        <div class="bg-overlay-bg" data-hover-animate="fadeIn"></div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="line"></div>

                    <div class="row col-mb-50">
                        <div class="col-12">
                            <?php $this->load->view('olddatatoshow/olddatatoshow.php'); ?>
                        </div>
                    </div>
                </div>

                <div class="section mb-0">
                    <h2 class="center mb-0 ls1">CRRU : CWIE Chanels</h2>
                </div>
                <div class="container topmargin-lg cleafix">
                    <div class="row clearfix">
                        <div class="owl-carousel portfolio-carousel carousel-widget" data-margin="20" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
                            <!-- load video component -->
                            <?php $this->load->view('z_template/components/videoComp', $videoData); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Load foot components
		============================================= -->
    <?php $this->load->view('z_template/components/footComp'); ?>

    </div>
</body>

<script>
    window.onload = function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('operation/getInternplaceData') ?>",
        }).done(function(data) {
            $("#internplace").html(data);
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('operation/getMouInData') ?>",
        }).done(function(data) {
            $("#mouplacein").html(data);
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('operation/getMouOutData') ?>",
        }).done(function(data) {
            $("#mouplaceout").html(data);
        });
        // ==========================================================

        var CalendarApp = function() {
            this.$body = $("body");
            this.$calendar = $("#calendar");
            this.$event = "#calendar-events div.calendar-events";
            this.$categoryForm = $("#add-new-event form");
            this.$extEvents = $("#calendar-events");
            this.$modal = $("#editCalendarEventModal");
            this.$saveCategoryBtn = $(".save-category");
            this.$calendarObj = null;
        };

        CalendarApp.prototype.init = function() {
            this.enableDrag();
            // Load calendar event
            var $this = this;

            calendarSetting = {
                firstDay: 1,
                locale: 'th',
                defaultView: "month",
                displayEventTime: false,
                handleWindowResize: true,
                header: {
                    left: "title",
                    right: "prev,next today",
                },
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: "<?php echo base_url('crud/calendar/getCalendarEvents/') ?>",
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            var events = [];
                            $.each(response.data, function(index, value) {
                                events.push({
                                    dbId: value.eventId,
                                    dbDetail: value.eventDetail != null ? value.eventDetail : "",
                                    dbPlace: value.eventPlace != null ? value.eventPlace : "",
                                    dbTimeStart: value.eventTimeStart != null ? value.eventTimeStart : "",
                                    dbTimeEnd: value.eventTimeEnd != null ? value.eventTimeEnd : "",
                                    dbOwner: value.eventOwner != null ? value.eventOwner : "",
                                    title: value.eventTitle,
                                    start: new Date(value.eventStart),
                                    end: new Date(value.eventEnd),
                                    backgroundColor: value.eventColor != null ? value.eventColor : "#06ADCE",
                                });
                            });
                            callback(events);
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert("ผิดพลาด!", error, 1500);
                        },
                    });
                },
                eventLimit: true,
                eventClick: function(calEvent, jsEvent, view) {
                    $this.onEventClick(calEvent, jsEvent, view);
                },
            }

            $this.$calendarObj = $this.$calendar.fullCalendar(calendarSetting);
        }

        CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {
            var $calendarApp = this;
            $calendarApp.$modal.modal("show");
            var form = $('<form novalidate></form>');
            form.append(
                `<div class="form-group">
                            <label class="form-label">ชื่อกิจกรรม</label><br>
                            <span class="lead mx-auto bottommargin">${calEvent.title ? calEvent.title : '-'}</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">รายละเอียด</label><br>
                            <span class="lead mx-auto bottommargin">${calEvent.dbDetail ? calEvent.dbDetail : '-'}</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">สถานที่</label><br>
                            <span class="lead mx-auto bottommargin">${calEvent.dbPlace ? calEvent.dbPlace : '-'}</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">หน่วยงาน</label><br>
                            <span class="lead mx-auto bottommargin">${calEvent.dbOwner ? calEvent.dbOwner : '-'}</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">เวลาเริ่มกิจกรรม</label><br>
                                    <span class="lead mx-auto bottommargin">${calEvent.dbTimeStart ? calEvent.dbTimeStart : '-'}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">เวลาสิ้นสุดกิจกรรม</label><br>
                                    <span class="lead mx-auto bottommargin">${calEvent.dbTimeEnd ? calEvent.dbTimeEnd : '-'}</span>
                                </div>
                            </div>
                        </div>
                </div>`
            );

            $calendarApp.$modal.find(".modal-body").empty().prepend(form).end();
        }

        CalendarApp.prototype.enableDrag = function() {
            //init events
            $(this.$event).each(function() {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()), // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                $(this).data("eventObject", eventObject);
                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0, //  original position after the drag
                });
            });
        };

        //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
        //initializing CalendarApp
        $.CalendarApp.init()
        // ==========================================================
    }
</script>