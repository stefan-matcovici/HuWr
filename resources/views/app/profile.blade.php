@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/profile.css')}}">
@endsection


<div class="profile-outside-container">
    <div class="profile-image-div">
        <img class="profile-image" src="https://cdn.pixabay.com/photo/2014/10/27/18/38/man-505353_960_720.jpg" alt="profile image">
    </div>
    <div class="profile-inside-container">
        <h2>
            LucaAndrei96
        </h2>
        <div class="name-div">
            <label>
                <b>Firstname:</b> Luca
            </label>
            <label>
                <b>Lastname:</b> Andrei
            </label>
        </div>

        <div class="location-div">
            <label>
                <b>From:</b> Iasi, Romania
            </label>
        </div>

        <div class="birthdate-div">
            <label>
                <b>Birthdate:</b> 08/06/1996
            </label>
        </div>

        <div class="gender-div">
            <label>
                <b>Gender:</b> male
            </label>
        </div>

        <div class="email-div">
            <label>
                <b>Email:</b> luca.andrei96@gmail.com
            </label>
        </div>

        <div class="last-migrations-div">
            <label>
                Last Migrations
            </label>
            <table>
                <tr>
                    <th class="to-cell"> <div> To</div> </th>
                    <th class="reason-cell"> <div>  Reason </div> </th>
                    <th class="from-cell"> <div>  From </div> </th>
                </tr>

                <tr>
                    <td class="to-cell">
                        <img class="flag-image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flag_of_Romania.svg/2000px-Flag_of_Romania.svg.png" alt="Romania flag"><br>
                        Country: Romania <br>
                        State:Iasi
                    </td>
                    <td class="reason-cell">
                        <div class="username">
                            User: AndreiLuca96
                        </div>
                        <div class="reason">
                            Reason: Economics
                        </div>
                        <img class="reason-image" src="https://openclipart.org/image/2400px/svg_to_png/222588/cash1.png" alt="Economics Reason photo">
                        <div class="number-adults-children-div">
                            <div class="number-adults-div">
                                Nr adults: 2
                            </div>
                            <div class="number-children-div">
                                Nr children: 0
                            </div>
                        </div>
                        <div class="time-elapsed">
                            5 minutes ago
                        </div>

                    </td>
                    <td class="from-cell">
                        <img class="flag-image" src="https://upload.wikimedia.org/wikipedia/en/thumb/a/ae/Flag_of_the_United_Kingdom.svg/1280px-Flag_of_the_United_Kingdom.svg.png" alt="England flag"><br>
                        Country: England <br>
                        State: London
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>