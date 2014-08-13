@extends('layout')

@section('content')
           <section class="content-wrapper">
                <div class="content __bg-white">
                    <!-- profile -->
                    <div class="profile clearfix">

                        <!-- profile-form -->
                        <div class="profile-form">
                            <div class="request-head-links">
                                <a href="#" class="request-housing __active"><em>Личные данные</em></a>
                                <a href="#" class="request-housing"><em>Смена пароля</em></a>
                            </div>
                            <div class="profile-line" id="mainProfile">
                                <div class="profile-inp-wr">
                                    <input class="input-text" value="<?= $user->first_name ?>" type="text" id="first_name" placeholder="Имя">
                                </div>
                                <div class="profile-inp-wr">
                                    <input class="input-text" value="<?= $user->last_name ?>" type="text" id="last_name" placeholder="Фамилия">
                                </div>
                                <div class="profile-inp-wr">
                                    <input class="input-text" value="<?= $user->email ?>" type="text" id="email" placeholder="E-mail">
                                </div>
                            </div>
                            
                            <div class="profile-line" id="passwordProfile" style="display: none">
                                <div class="profile-inp-wr">
                                    <input class="input-text" type="text" id="oldPassword" placeholder="Старый пароль">
                                </div>
                                <div class="profile-inp-wr">
                                    <input class="input-text" type="text" id="newPassword" placeholder="Новый пароль">
                                </div>
                                <div class="profile-inp-wr">
                                    <input class="input-text" type="text" id="repeatPassword" placeholder="Повторите пароль">
                                </div>
                            </div>
                            
                            
                            <div class="profile-btns-bar">
                                <a href="#" class="btn--profile __btn-green" id="save">Сохранить</a>
                                <a href="#" class="btn--profile __btn-red" id="cancel">Отмена</a>
                            </div>
                        </div>
                        <!-- /profile-form -->

                        <div class="profile-load-photo">
                            <div class="profile-load-img">
                                <div class="profile-load-img-empty">нет фото</div>
                                <img src="/avatars/3.jpg" alt="" hidden>
                                <div class="search-load-controls-wr" hidden>
                                    <a href="#" class="page-conrol __close" ></a>
                                </div>
                            </div>
                           <div class="input-filesuctom" style="display: block;">
                              <a class="btn--profile-load __btn-green">Загрузить</a>
                              <input type="file" id="fileupload" name="avatarFile" multiple="">
                            </div>
                            <section>
                                    <div class="content">
                                        <form id="myForm" action="{{action('UploadController@postUploadAvatar')}}" method="post" enctype="multipart/form-data">
                                            <input type="file" size="60" name="avatarFile">
                                            <input type="submit" value="Ajax File Upload">
                                        </form>

                                        <div id="progress">
                                               <div id="bar"></div>
                                               <div id="percent">0%</div >
                                        </div>
                                        <br/>

                                        <div id="message"></div>
                                    </div>
                                </section>
                        </div>
                    </div>
                    <!-- /profile -->
                </div>
            </section>        

@stop