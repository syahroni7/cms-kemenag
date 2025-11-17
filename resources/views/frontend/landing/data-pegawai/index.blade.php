@extends('frontend.layouts.master')
@section('title', $title)

@section('_styles')

@endsection

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="bi bi-house"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Category</a></li>
                    <li class="breadcrumb-item active current">About</li>
                </ol>
            </nav>
        </div>

        <div class="title-wrapper">
            <h1>Daftar Pegawai</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
        </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="author-profile" class="author-profile section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="author-profile-1">

          <div class="row">
            <!-- Author Info -->
            <div class="col-lg-4 mb-4 mb-lg-0">
              <div class="author-card" data-aos="fade-up">
                <div class="author-image">
                  <img src="blogy-assets/img/person/person-m-5.webp" alt="Author" class="img-fluid rounded">
                </div>

                <div class="author-info">
                  <h2>Kevin Anderson</h2>
                  <p class="designation">Senior Technology Writer</p>

                  <div class="author-bio">
                    Through my articles, I explore the intersection of technology and society, focusing on how emerging tech shapes our daily lives and future possibilities.
                  </div>

                  <div class="author-stats d-flex justify-content-between text-center my-4">
                    <div class="stat-item">
                      <h4 data-purecounter-start="0" data-purecounter-end="147" data-purecounter-duration="1" class="purecounter"></h4>
                      <p>Articles</p>
                    </div>
                    <div class="stat-item">
                      <h4 data-purecounter-start="0" data-purecounter-end="13" data-purecounter-duration="1" class="purecounter"></h4>
                      <p>Awards</p>
                    </div>
                    <div class="stat-item">
                      <h4 data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="purecounter">K</h4>
                      <p>Followers</p>
                    </div>
                  </div>

                  <div class="social-links">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Author Content -->
            <div class="col-lg-8">
              <div class="author-content" data-aos="fade-up" data-aos-delay="200">
                <div class="content-header">
                  <h3>About Me</h3>
                </div>
                <div class="content-body">
                  <p>With over a decade of experience in technology journalism, I've had the privilege of witnessing and documenting the rapid evolution of our digital landscape. My work spans from in-depth analysis of artificial intelligence and its implications to hands-on reviews of the latest consumer technology.</p>

                  <div class="expertise-areas">
                    <h4>Areas of Expertise</h4>
                    <div class="tags">
                      <span>Artificial Intelligence</span>
                      <span>Cybersecurity</span>
                      <span>Smart Home Technology</span>
                      <span>Digital Privacy</span>
                      <span>Consumer Electronics</span>
                      <span>Future Tech Trends</span>
                    </div>
                  </div>

                  <div class="featured-articles mt-5">
                    <h4>Featured Articles</h4>
                    <div class="row g-4">
                      <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <article class="article-card">
                          <div class="article-img">
                            <img src="blogy-assets/img/blog/blog-post-10.webp" alt="Article" class="img-fluid">
                          </div>
                          <div class="article-details">
                            <div class="post-category">Technology</div>
                            <h5><a href="#">The Future of AI in Everyday Computing</a></h5>
                            <div class="post-meta">
                              <span><i class="bi bi-clock"></i> Jan 15, 2024</span>
                              <span><i class="bi bi-chat-dots"></i> 24 Comments</span>
                            </div>
                          </div>
                        </article>
                      </div>

                      <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <article class="article-card">
                          <div class="article-img">
                            <img src="blogy-assets/img/blog/blog-post-6.webp" alt="Article" class="img-fluid">
                          </div>
                          <div class="article-details">
                            <div class="post-category">Privacy</div>
                            <h5><a href="#">Understanding Digital Privacy in 2024</a></h5>
                            <div class="post-meta">
                              <span><i class="bi bi-clock"></i> Feb 3, 2024</span>
                              <span><i class="bi bi-chat-dots"></i> 18 Comments</span>
                            </div>
                          </div>
                        </article>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Team Section -->
    <section id="team" class="team section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Team</h2>
            <div><span>Check Our</span> <span class="description-title">Team</span></div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-m-7.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                            <p>Aliquam iure quaerat voluptatem praesentium possimus unde laudantium vel dolorum distinctio dire flow</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-f-8.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                            <p>Labore ipsam sit consequatur exercitationem rerum laboriosam laudantium aut quod dolores exercitationem ut</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-m-6.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                            <p>Illum minima ea autem doloremque ipsum quidem quas aspernatur modi ut praesentium vel tque sed facilis at qui</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-f-4.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>Amanda Jepson</h4>
                            <span>Accountant</span>
                            <p>Magni voluptatem accusamus assumenda cum nisi aut qui dolorem voluptate sed et veniam quasi quam consectetur</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-m-12.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>Brian Doe</h4>
                            <span>Marketing</span>
                            <p>Qui consequuntur quos accusamus magnam quo est molestiae eius laboriosam sunt doloribus quia impedit laborum velit</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="team-member d-flex">
                        <div class="member-img">
                            <img src="blogy-assets/img/person/person-f-9.webp" class="img-fluid" alt="" loading="lazy">
                        </div>
                        <div class="member-info flex-grow-1">
                            <h4>Josepha Palas</h4>
                            <span>Operation</span>
                            <p>Qui consequuntur quos accusamus magnam quo est molestiae eius laboriosam sunt doloribus quia impedit laborum velit</p>
                            <div class="social">
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section><!-- /Team Section -->

</main>
@endsection

@section('_scripts')
@endsection