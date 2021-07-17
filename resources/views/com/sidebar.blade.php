
<aside id="sidebar_main" style="background: rgba(255,255,255,0.9)">

    <div class="sidebar_main_header " style="max-height: 50px;">

        <table cellspacing="8">
            <tr>
                @if (auth()->user()->image=="")
                                <?php $image='no-avater.png';  ?>
                            @else
                                <?php $image=auth()->user()->image;  ?>
                            @endif
                <td style="padding-left: 15px;"><img class="img-circle md-user-image"  src="{{url('uploads/files/users').'/'.$image}}"></td>
                <td>{{auth()->user()->name}}</td>
            </tr>
        </table>

    </div>

    <div class="menu_section">
        <ul>
            <li title="Dashboard">
                <a href="/home">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">home</i></span>
                    <span class="menu_title">Select Company</span>
                </a>

            </li>
            <li title="Dashboard">
                <a href="/file/directories">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">home</i></span>
                    <span class="menu_title">Home</span>
                </a>

            </li>
            @if(auth()->user()->name=='admin')
            <li title="Dashboard">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">account_balance</i></span>
                    <span class="menu_title">Company</span>
                </a>
                <ul>
                    <li><a href="/workstation/new">Add New Company</a></li>
                    <li><a href="/workstation/all">All Companies</a></li>

                </ul>

            </li>
            

            <li title="Dashboard">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">account_circle</i></span>
                    <span class="menu_title">Users</span>
                </a>
                <ul>
                    <li><a href="/user/new">Add New User</a></li>
                    <li><a href="/user/all">All Users</a></li>

                </ul>

            </li>
            @endif
            <li title="Chats">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">calendar_view_day</i></span>
                    <span class="menu_title">Directories</span>
                </a>
                <ul>
                    <li><a href="/directory/new">Add New Main directory</a></li>
                    <li><a href="/directory/all">All Main Directories</a></li>
                    <li><a href="/subdirectory/new">Add New Subdirectory</a></li>
                    <li><a href="/subdirectory/all">All Sub Directories</a></li>

                </ul>

            </li>

            <li title="Chats">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">description</i></span>
                    <span class="menu_title">Files</span>
                </a>
                <ul>
                    <li><a href="/file/new">Add New</a></li>
                    <li><a href="/file/directories">Select Files</a></li>
                    <li><a href="/file">Files Details</a></li>
                    <li><a href="/file/update">Update Files</a></li>
                    
                    
                </ul>

            </li>
            <li title="Chats">
                <a href="/archive">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">delete_forever</i></span>
                    <span class="menu_title">Archived Files</span>
                </a>


            </li>

            <li title="Chats">
                <a href="/title">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">label</i></i></span>
                    <span class="menu_title">Give Titles</span>
                </a>


            </li>
            <li title="Chats">
                <a href="/merged_files">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">list</i></span>
                    <span class="menu_title">Created Profiles</span>
                </a>


            </li>
             <li title="Chats">
                <a href="/archived_merged_files">
                    <span class="menu_icon"><i class="material-icons uk-text-primary">list</i></span>
                    <span class="menu_title">Archived Profiles</span>
                </a>


            </li>



        </ul>
    </div>
</aside>