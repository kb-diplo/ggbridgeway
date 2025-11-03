    <?php
    // Get dynamic settings for footer
    $footer_settings = [];
    try {
        $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('facebook_url', 'twitter_url', 'instagram_url', 'youtube_url', 'linkedin_url', 'school_motto', 'contact_hours', 'developer_name', 'developer_url', 'show_developer_credit')");
        $stmt->execute();
        $results = $stmt->fetchAll();
        foreach ($results as $row) {
            $footer_settings[$row['setting_key']] = $row['setting_value'];
        }
    } catch(PDOException $e) {
        // Use defaults if settings table doesn't exist
        $footer_settings = [
            'facebook_url' => 'https://facebook.com/bridgewayschool',
            'twitter_url' => 'https://twitter.com/bridgewayschool',
            'instagram_url' => 'https://instagram.com/bridgewayschool',
            'youtube_url' => 'https://youtube.com/@bridgewayschool',
            'linkedin_url' => '',
            'school_motto' => 'Excellence and Integrity - Lead with Values',
            'contact_hours' => 'Monday - Friday: 7:00 AM - 5:00 PM, Saturday: 8:00 AM - 12:00 PM',
            'developer_name' => 'Lance Services',
            'developer_url' => 'https://lanceservices.pythonanywhere.com/',
            'show_developer_credit' => '1'
        ];
    }
    ?>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- School Information -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-school me-2"></i>Githunguri Bridgeway Preparatory School</h5>
                    <p class="mb-3"><?php echo htmlspecialchars(isset($footer_settings['school_motto']) ? $footer_settings['school_motto'] : 'Excellence and Integrity - Lead with Values'); ?></p>
                    <p><i class="fas fa-map-marker-alt me-2"></i><?php echo SCHOOL_ADDRESS; ?></p>
                    <p><i class="fas fa-phone me-2"></i><?php echo SCHOOL_PHONE; ?></p>
                    <p><i class="fas fa-envelope me-2"></i><?php echo SCHOOL_EMAIL; ?></p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/about.php">About Us</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/academics.php">Academics</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/admissions.php">Admissions</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/student-life.php#gallery">Gallery</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/downloads.php">Downloads</a></li>
                    </ul>
                </div>

                <!-- Academic Programs -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Academic Programs</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/academics.php#nursery">Nursery School</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/academics.php#primary">Primary School</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/academics.php#kcpe">KCPE Preparation</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/student-life.php">Co-curricular Activities</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/student-life.php#events">School Events</a></li>
                    </ul>
                </div>

                <!-- Social Media & Newsletter -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Connect With Us</h5>
                    <div class="mb-3">
                        <?php if(!empty($footer_settings['facebook_url'])): ?>
                            <a href="<?php echo $footer_settings['facebook_url']; ?>" target="_blank" class="me-3" style="font-size: 1.5rem;" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($footer_settings['twitter_url'])): ?>
                            <a href="<?php echo $footer_settings['twitter_url']; ?>" target="_blank" class="me-3" style="font-size: 1.5rem;" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($footer_settings['instagram_url'])): ?>
                            <a href="<?php echo $footer_settings['instagram_url']; ?>" target="_blank" class="me-3" style="font-size: 1.5rem;" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($footer_settings['youtube_url'])): ?>
                            <a href="<?php echo $footer_settings['youtube_url']; ?>" target="_blank" class="me-3" style="font-size: 1.5rem;" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($footer_settings['linkedin_url'])): ?>
                            <a href="<?php echo $footer_settings['linkedin_url']; ?>" target="_blank" class="me-3" style="font-size: 1.5rem;" title="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <h6>School Hours</h6>
                    <p><?php echo nl2br(htmlspecialchars(isset($footer_settings['contact_hours']) ? $footer_settings['contact_hours'] : 'Monday - Friday: 7:00 AM - 5:00 PM\nSaturday: 8:00 AM - 12:00 PM')); ?></p>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; <?php echo date('Y'); ?> Githunguri Bridgeway Preparatory School. All rights reserved.</p>
                        <p class="mb-0">
                            <small>Website developed by 
                                <a href="https://lanceservices.pythonanywhere.com/" 
                                   target="_blank" style="color: var(--maroon); text-decoration: none;">
                                    Lance Services
                                </a>
                            </small>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="<?php echo SITE_URL; ?>/privacy-policy.php" class="me-3">Privacy Policy</a>
                        <a href="<?php echo SITE_URL; ?>/terms-of-service.php" class="me-3">Terms of Service</a>
                        <a href="<?php echo SITE_URL; ?>/cookies-policy.php">Cookies Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20Githunguri%20Bridgeway%20Preparatory%20School" 
       class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>

    <!-- Cookie Consent Banner -->
    <div id="cookieConsent" class="cookie-consent" style="display: none;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="mb-0">
                        <i class="fas fa-cookie-bite me-2"></i>
                        This website uses cookies to ensure you get the best experience. 
                        <a href="<?php echo SITE_URL; ?>/cookies-policy.php" class="text-white">Learn more</a>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-sm btn-light me-2" onclick="acceptCookies()">Accept</button>
                    <button class="btn btn-sm btn-outline-light" onclick="declineCookies()">Decline</button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20Githunguri%20Bridgeway%20Preparatory%20School" 
       class="whatsapp-btn" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" title="Go to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Scroll to top functionality
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            const scrollBtn = document.getElementById("scrollToTop");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollBtn.classList.add("show");
            } else {
                scrollBtn.classList.remove("show");
            }
        }

        // Scroll to top when button is clicked
        document.getElementById("scrollToTop").addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Fade in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
