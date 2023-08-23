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
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row d-flex no-block">
                    <div class="card mx-auto" style="max-width: 1000px;">
                        <div class="chat-main-box">
                            <div class="chat-right-aside">
                                <div class="chat-main-header">
                                    <div class="p-3 b-b">
                                        <h4 class="box-title">Chat Message</h4>
                                    </div>
                                </div>
                                <div class="chat-rbox">
                                    <ul class="chat-list p-3">
                                        <div id="message-display-box"></div>
                                    </ul>
                                </div>
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-10">
                                            <textarea id="message" placeholder="Type your message here" class="form-control border-0"></textarea>
                                        </div>
                                        <div class="col-2 text-end">
                                            <button id="send" type="button" class="btn btn-info btn-circle btn-lg text-white"><i class="fas fa-paper-plane"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- load foot component -->
        <?php $this->load->view('z_template/components/footComp'); ?>
    </div>

    <!-- modal container -->
    <div id="modal-container"></div>

    <!-- pusher -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- cookies -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>

    <script>
        window.onload = function() {
            // ==========================================================
            const pusher = new Pusher('7226a07b4e54ff05b233', {
                cluster: 'ap1'
            });

            const channel = pusher.subscribe('chat-channel-local');

            channel.bind('new-message', function(data) {

                // Get the user's unique ID from the data
                var userId = <?php echo $this->session->userdata('crudSessionData')['crudAuthId']; ?>;

                // Get the user's stored scroll position from the cookie
                var scrollPosition = Cookies.get('scrollPosition_' + userId);

                if (data.authID != <?php echo $this->session->userdata('crudSessionData')['crudAuthId'] ?>) {
                    $html = `<li id="chatID-${data.chatID}">
                                <div class="chat-img"><img src="${data.userImage}" alt="user"/></div>
                                <div class="chat-content">
                                    <h5>${data.userNameSurname}</h5>
                                    <div class="box bg-light-info">${data.userMessage}</div>
                                    <div class="chat-time">${data.timeStamp}</div>
                                </div>
                            </li>
                `;
                } else {
                    $html = `<li id="chatID-${data.chatID}" class="reverse">
                                <div class="chat-content">
                                    <h5>${data.userNameSurname}</h5>
                                    <div class="box bg-light-info">${data.userMessage}</div>
                                    <div class="chat-time">${data.timeStamp}</div>
                                </div>
                                <div class="chat-img"><img src="${data.userImage}" alt="user"/></div>
                            </li>
                `;
                }

                let existingMessage = $('#message-display-box').find('#chatID-' + data.chatID);

                if (existingMessage.length === 0) {
                    $('#message-display-box').append($html);

                    // Scroll to the bottom if the user was near the bottom before
                    if (scrollPosition !== undefined && isUserNearBottom(scrollPosition)) {
                        $(".chat-rbox").scrollTop($(".chat-rbox")[0].scrollHeight);
                    }
                }

            });

            $.get('chat/getMessage', function(data) {
                $(".chat-rbox").scrollTop($(".chat-rbox")[0].scrollHeight);
            });

            $(".chat-rbox").on('scroll', function() {
                const userId = <?php echo $this->session->userdata('crudSessionData')['crudAuthId']; ?>; // Implement a function to get the user's unique ID
                const scrollPosition = $(this).scrollTop();
                Cookies.set('scrollPosition_' + userId, scrollPosition);
            });

            // keydown enter
            $("#message").keydown(function(event) {
                if (event.keyCode === 13 && !event.shiftKey) {
                    event.preventDefault(); // Prevent the default Enter behavior (newline)
                    sendMessage();
                }
            });

            // Send button click event
            $('#send').click(function() {
                const message = $('#message').val();
                $.post('chat/send', {
                    message: message
                });
                $('#message').val('');
            });
            // ==========================================================
        };

        function sendMessage() {
            const message = $('#message').val();
            $.post('chat/send', {
                message: message
            });
            $('#message').val('');
        }

        // Check if the user is near the bottom of the chat box
        function isUserNearBottom(scrollPosition) {
            var chatBox = $(".chat-rbox")[0];
            return scrollPosition + chatBox.clientHeight + 20 >= chatBox.scrollHeight;
        }
    </script>