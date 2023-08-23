<!-- load pre loader component -->
<?php $this->load->view('z_template/components/preloaderComp'); ?>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/topbarComp'); ?>

    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/leftbarComp'); ?>

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <!-- load bread crumb component -->
            <?php $this->load->view('z_template/components/breadCrumbComp', isset($page) ? $page : ''); ?>

            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <!-- load calendar modal component -->
                    <?php $this->load->view('z_template/components/calendarComp'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- load foot component -->
    <?php $this->load->view('z_template/components/footComp'); ?>
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<script>
    window.onload = function() {
        // ==========================================================
        <?php if ($this->session->flashdata('welcome')) { ?>
            showSuccessSweetalert('ยินดีต้อนรับ', '', 1500);
        <?php } ?>

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
            let calendarSetting = {};
            // admin, faculty permission (editable)
            <?php if (in_array($this->session->userdata('crudSessionData')['crudPermission'], ['admin', 'faculty'])) { ?>
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
                    droppable: true,
                    eventLimit: true,
                    editable: true,
                    selectable: true,
                    events: function(start, end, timezone, callback) {
                        $.ajax({
                            url: "<?php echo base_url('crud/calendar/getCalendarEvents/') . $this->session->userdata('crudSessionData')['crudAuthId'] ?>",
                            type: "GET",
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
                                        dbAuthID: value.eventAuthID,
                                        title: value.eventTitle,
                                        start: new Date(value.eventStart),
                                        end: new Date(value.eventEnd),
                                        backgroundColor: value.eventColor != null ? value.eventColor : "#06ADCE",
                                        allDay: true
                                    });
                                });
                                callback(events);
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert("ผิดพลาด!", error, 1500);
                            },
                        });
                    },
                    eventResize: function(event, delta, revertFunc) {
                        if (event.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' && '<?php echo $this->session->userdata('crudSessionData')['crudPermission'] ?>' != 'admin') {
                            showErrorSweetalert("ผิดพลาด!", 'Permission Denial!', 1500);
                            $this.$calendar.fullCalendar('refetchEvents');
                            return;
                        }
                        $this.onEventResize(event, delta, revertFunc);
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    },
                    eventDrop: function(event, delta, revertFunc) {
                        if (event.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' && '<?php echo $this->session->userdata('crudSessionData')['crudPermission'] ?>' != 'admin') {
                            showErrorSweetalert("ผิดพลาด!", 'Permission Denial!', 1500);
                            $this.$calendar.fullCalendar('refetchEvents');
                            return;
                        }
                        $this.onEventDrop(event, delta, revertFunc)
                    },
                    select: function(start, end, allDay) {
                        $this.onSelect(start, end, allDay);
                    },

                }
            <?php }
            // all others permission (readonly)
            else { ?>
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
                            url: "<?php echo base_url('crud/calendar/getCalendarEvents') ?>",
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
            <?php } ?>
            $this.$calendarObj = $this.$calendar.fullCalendar(calendarSetting);
        }

        CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {
            var $calendarApp = this;
            $calendarApp.$modal.modal("show");
            var form = $('<form novalidate></form>');
            form.append(
                `<?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                    <div class="form-group">
                            <label for="calendarEventName" class="form-label">ชื่อกิจกรรม</label>
                            <input class="form-control" type=text name="calendarEventName" value="${calEvent.title}" required/>
                            <div class="invalid-feedback input-group-label">
                                กรุณาป้อนชื่อกิจกรรม
                            </div>       
                        </div>
                        <div class="form-group">
                            <label for="calendarEventDetail" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" name="calendarEventDetail" rows="5">${calEvent.dbDetail}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="calendarEventPlace" class="form-label">สถานที่</label>
                            <input class="form-control" type=text name="calendarEventPlace" value="${calEvent.dbPlace}" />
                        </div>
                        <div class="form-group">
                            <label for="calendarEventPlace" class="form-label">หน่วยงาน</label>
                            <input class="form-control" type=text value="${calEvent.dbOwner}" readonly />
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventStartTime" class="form-label">เวลาเริ่มกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventStartTime" value="${calEvent.dbTimeStart}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventEndTime" class="form-label">เวลาสิ้นสุดกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventEndTime" value="${calEvent.dbTimeEnd}" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info waves-effect waves-light text-white me-auto">
                                <i class="fa fa-check"></i> บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light text-white">ลบข้อมูล</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <label for="facultyNameTH" class="form-label">ชื่อกิจกรรม</label>
                            <input class="form-control" type=text name="calendarEventName" value="${calEvent.title}" ${calEvent.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 'readonly' : ''}/>
                        </div>
                        <div class="form-group">
                            <label for="calendarEventDetail" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" rows="5" name="calendarEventDetail" ${calEvent.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 'readonly' : ''} >${calEvent.dbDetail}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="facultyNameTH" class="form-label">สถานที่</label>
                            <input class="form-control" type=text name="calendarEventPlace" value="${calEvent.dbPlace}" ${calEvent.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 'readonly' : ''}/>
                        </div>
                        <div class="form-group">
                            <label for="calendarEventPlace" class="form-label">หน่วยงาน</label>
                            <input class="form-control" type=text value="${calEvent.dbOwner}" readonly />
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventStartTime" class="form-label">เวลาเริ่มกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventStartTime" value="${calEvent.dbTimeStart}" ${calEvent.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 'readonly' : ''}>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventEndTime" class="form-label">เวลาสิ้นสุดกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventEndTime" value="${calEvent.dbTimeEnd}" ${calEvent.dbAuthID != '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 'readonly' : ''}>
                                </div>
                            </div>
                        </div>
                        ${calEvent.dbAuthID == '<?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>' ? 
                            `<div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect waves-light text-white me-auto">
                                    <i class="fa fa-check"></i> บันทึกข้อมูล
                                </button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light text-white">ลบข้อมูล</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                            </div>` : ''
                        }
                    <?php } ?>
                </div>`
            );

            // delete event
            $calendarApp.$modal.find(".modal-body").empty().prepend(form).end().find(".delete-event").unbind("click").click(function() {
                Swal.fire({
                    title: 'ยืนยันการลบ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ยืนยันการลบ',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        let eventID = calEvent.dbId;
                        $.ajax({
                            url: "<?php echo base_url('crud/calendar/onDeleteCalendarEvents/') ?>" + eventID,
                            type: "POST",
                            dataType: "json",
                            beforeSend: function() {
                                showLoadingSweetalert();
                            },
                            success: function(response) {
                                if (!response.status) {
                                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                    return;
                                }
                                showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert("ผิดพลาด!", error, 1500);
                                return;
                            },
                        });
                        $calendarApp.$calendarObj.fullCalendar("removeEvents", function(ev) {
                            return ev._id == calEvent._id;
                        });
                        $calendarApp.$modal.modal("hide");
                    }
                })
            });

            let eventId = calEvent.dbId;

            // update event detail
            form.on("submit", function() {
                event.preventDefault();
                if (this.checkValidity() === false) {
                    form.addClass('was-validated');
                    event.stopPropagation();
                    return;
                }
                $.ajax({
                    url: "<?php echo base_url('crud/calendar/onEditCalendarEventDetail/') ?>" + eventId,
                    type: "POST",
                    dataType: "json",
                    data: form.serialize(),
                    beforeSend: function() {
                        showLoadingSweetalert();
                    },
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        $calendarApp.$calendarObj.fullCalendar('refetchEvents');
                        showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                        $calendarApp.$modal.modal("hide");
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert("ผิดพลาด!", error, 1500);
                        return;
                    },
                });
            });
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

        CalendarApp.prototype.onEventDrop = function(event, delta, revertFunc) {

            const $calendarApp = this;
            $.ajax({
                url: "<?php echo base_url('crud/calendar/onEventDrop') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    eventID: event.dbId,
                    eventStart: event.start.format('YYYY-MM-DD'),
                    eventEnd: event.end != null ? event.end.format('YYYY-MM-DD') : event.start.format('YYYY-MM-DD'),
                },
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    $calendarApp.$calendarObj.fullCalendar('refetchEvents');
                    showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert("ผิดพลาด!", error, 1500);
                    return;
                },
            });
        }

        CalendarApp.prototype.onEventResize = function(event, delta, revertFunc) {

            var $calendarApp = this;
            $.ajax({
                url: "<?php echo base_url('crud/calendar/onEventResize') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    eventID: event.dbId,
                    eventEnd: event.end.format('YYYY-MM-DD'),
                },
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    $calendarApp.$calendarObj.fullCalendar('refetchEvents');
                    showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert("ผิดพลาด!", error, 1500);
                    return;
                },
            });
        }

        CalendarApp.prototype.onSelect = function(start, end, allDay) {
            var $calendarApp = this;
            $calendarApp.$modal.modal("show");
            var form = $('<form novalidate></form>');
            form.append(
                `
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                            <label for="calendarEventName" class="form-label">ชื่อกิจกรรม</label>
                            <input class="form-control" type=text name="calendarEventName" value="" required/>
                            <div class="invalid-feedback input-group-label">
                                กรุณาป้อนชื่อกิจกรรม
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="calendarEventDetail" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" name="calendarEventDetail" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="calendarEventPlace" class="form-label">สถานที่</label>
                            <input class="form-control" type=text name="calendarEventPlace" value="" />
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventStartTime" class="form-label">เวลาเริ่มกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventStartTime" value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="calendarEventEndTime" class="form-label">เวลาสิ้นสุดกิจกรรม</label>
                                    <input class="form-control" type="time" name="calendarEventEndTime" value="" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light text-white me-auto">
                                <i class="fa fa-check"></i> เพิ่มข้อมูล
                            </button>
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>
                </div>`
            );

            $calendarApp.$modal.find(".modal-body").empty().prepend(form);

            $calendarApp.$modal.find('form').on('submit', function() {
                event.preventDefault();
                if (this.checkValidity() === false) {
                    form.addClass('was-validated');
                    event.stopPropagation();
                    return;
                }
                $.ajax({
                    url: "<?php echo base_url('crud/calendar/onAddCalendarEvent') ?>",
                    type: "POST",
                    dataType: "json",
                    data: form.serialize() + '&calendarEventStart=' + start.format() + '&calendarEventEnd=' + end.format(),
                    beforeSend: function() {
                        showLoadingSweetalert();
                    },
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        $calendarApp.$calendarObj.fullCalendar('refetchEvents');
                        showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                        $calendarApp.$modal.modal("hide");
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert("ผิดพลาด!", error, 1500);
                        return;
                    },
                });
            });

            $calendarApp.$calendarObj.fullCalendar('unselect');
        }

        //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
        //initializing CalendarApp
        $.CalendarApp.init()

        // ==========================================================
    }
</script>