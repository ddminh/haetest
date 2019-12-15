<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>HAE Test</title>
  <meta name="description" content="HAE Test">
  <meta name="author" content="SitePoint">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="asset/css/font-awesome.css">
  <script src="asset/js/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" href="asset/css/bootstrap.css">
  <script src="asset/js/bootstrap.js"></script>
  
  <!-- customize css and javascript -->
  <link rel="stylesheet" href="asset/css/style.css">
  <script src="asset/js/script.js"></script>
  <?php 
    session_start();
    /* Load the guest content */
    // connect to database
    $page = isset($_GET['page'])?$_GET['page']:1;
    if($page<1) $page = 1;
    $hostName = 'localhost';
    $userName = 'root';
    $passWord = '';
    $databaseName = 'haetest';
    $connect = mysqli_connect($hostName, $userName, $passWord, $databaseName);
    if (!$connect) {
        exit('Can not connect to database!');
    }
    
    // Get the informations
    $offset = ($page-1)*6;
    $sql = "SELECT * from messages WHERE status != 'deleted' ORDER BY created_at DESC LIMIT 6 OFFSET $offset ";
    $result = $connect->query($sql);
    $rows = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } 
    if(count($rows) % 2 == 1)
        $rows[] = array('message' => '', 'name' => '', 'created_at' => '');
?>
  <script type="text/javascript">
      var page = <?php echo $page; ?>;
  </script>
</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class ="information">
                    <div class="logo">
                        <img src="asset/images/haelogo.png" class="logo-image" alt="Hae Logo" />
                    </div>
                    <p>
                        Feel free to leave us a short message to tell us what you think to our services
                    </p>
                    <div class="post-message">
                        <a id="post-message" href="" class="btn btn-danger post-button" data-toggle="modal" data-target="#message-dialog">Post a Message</a>
                    </div>
                     <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
                    <div class="admin-login login">
                    
                        <p>Welcome "<?php echo $_SESSION['username']; ?>"</p>
                        <a href="action/actions.php?action=logout">Logout</a>
                    </div>
                     <?php else: ?>
                        <div class="admin-login login">
                            <a href="" class="btn btn-link" data-toggle="modal" data-target="#login-dialog" >Admin login</a>
                        </div>
                     <?php endif; ?>
                </div>
                
            </div>
            
            <div class="col-md-1 blank-spacing">
                
            </div>
            <div class="col-md-7 blank-spacing" >
                <?php foreach($rows as $key=> $row): ?>
                    <?php if($key % 2 == 0 ):?>
                        <div class="row" style="padding-top: 20px;">
                    <?php endif; ?>
                    <div class="col-md-5">
                        <div class="card card-info" rel="<?php echo $row['id']; ?>">
                            <div class="card-body guest-info">
                              <p class="card-text"><?php echo $row['message']; ?></p>
                              <div>
                                  <div class="guest-info-2">
                                      <div class='guest-name'><?php echo $row['name']; ?></div>
                                      <div class='guest-date'><?php echo date('d M, Y  h:i A', strtotime($row['created_at'])); ?></div>
                                  </div>
                                  <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
                                  <div>
                                    <div class= "guest-info-edit">
                                        <a class="btn btn-danger edit-button"  style="padding: 0px 2px 0px 2px; margin: 10px 10px 0px 0px;" data-toggle="modal" data-target="#edit-dialog" onclick="clickEditButton(this)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div >
                                    <div class="guest-info-edit">
                                        <a class="btn btn-danger delete-button" style="padding: 0px 2px 0px 2px; margin: 10px 10px 0px 0px;" data-toggle="modal" data-target="#delete-dialog" onclick="clickDeleteButton(this)">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                  </div>
                                  <?php endif; ?>
                              </div>
                            </div>
                          </div>
                    </div>
                    <?php if($key % 2 == 0 ):?>
                        <div class="col-md-2"></div>
                    <?php endif; ?> 
                    <?php if($key % 2 == 1):?>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>

                <!-- Pagination -->
                <div class="row" style="padding: 20px 0 40px 0; ">
                  
                    <div class="col-md-12" style="text-align: center; color: white">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center" >                  
                                <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page-1;?>"><i class="fa fa-chevron-left"></i></a></li>
                                <li class="page-item" id="li_page1"><a class="page-link" href="index.php?page=1">1</a></li>
                                <li class="page-item" id="li_page2"><a class="page-link" href="index.php?page=2">2</a></li>
                                <li class="page-item" id="li_page3"><a class="page-link" href="index.php?page=3">3</a></li>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page+1;?>"><i class="fa fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                        
                    </div>
                   
                </div>
            </div>
            <div class="col-md-1 blank-spacing">
                
            </div>
        </div>
        
        <!-- ******************
        **** MODAL DIALOG *****
        *********************** !-->
        <!-- Post Message Dialog-->
        <div id="message-dialog" class="modal">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content" style="padding: 20px;">
                  <div class="dialog-message-title">
                      <h3 class="modal-title" style="width:90%; display:block; float: left;">Let we know your idea</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <a href="" class="btn btn-success" id="dialogMesageSuccess" style="display:none;">You has submitted the message successfully</a>
                  <a href="" class="btn btn-danger" id="dialogMesageError" style="display:none;">Can not submit your message</a>
                  
                  <div class="dialog-message-form">
                      
                      <form id="dialogMessage" action="#" onclick="return false;">
                      <fieldset class="form-group">
                          <label for="dialogMessageName" style="color: blue;">Your full name <span style="color: red;">*</span></label>
                          <input type="text" class="form-control" id="dialogMessageName" placeholder="Input your full name" />
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="v" style="color: blue;">Your email <span style="color: red;">*</span></label>
                          <input type="text" class="form-control" id="dialogMessageEmail" placeholder="Input your email" />
                      </fieldset>
                      <fieldset class="form-group">
                        <label for="vs" style="color: blue;">Your message (maximum 300 characters )<span style="color: red;">*</span></label>
                        <textarea class="form-control" id="dialogMessageContent" rows="3" placeholder="Input your message"></textarea>
                      </fieldset>
                      <fieldset style="text-align: center;">
                        <button type="submit" id="dialogMessageSubmit" class="btn btn-primary mb-2" style="text-align: center;">Submit</button>
                      </fieldset>
                  </form>
                  </div>
                  
              </div>

            </div>
          </div>
        
        <!-- Login Dialog -->
        <div id="login-dialog" class="modal">
            <div class="modal-dialog">
                <div class="modal-content" style="padding: 20px;">
                    <div class="dialog-message-title"> 
                      <h3 class="modal-title" style="width:90%; display:block; float: left;">Admin Login</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  
                  <a href="" class="btn btn-success" id="dialogLoginSuccess" style="display:none;">You has login successfully</a>
                  <a href="" class="btn btn-danger" id="dialogLoginError" style="display:none;">Can not login</a>
                  
                  
                  <div class="dialog-message-form">
                      <form action="#" onclick="return false;">
                          <fieldset class="form-group">
                            <label for="dialogLoginUsernName" style="color: blue;">Username <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="dialogLoginUsername" placeholder="Input your username"/>
                          </fieldset>
                          <fieldset class="form-group">
                            <label for="dialogLoginPassword" style="color: blue;">Password <span style="color: red;">*</span></label>
                            <input type="password" class="form-control" id="dialogLoginPassword" placeholder="Input your password" />
                        </fieldset>
                          <fieldset style="text-align: center;">
                            <button type="submit" id="dialogLoginSubmit" class="btn btn-primary mb-2" style="text-align: center;">Login</button>
                          </fieldset>
                      </form>
                  </div>
                </div>
            </div>
        </div>
        
        <!-- Edit Message Dialog -->
        <div id="edit-dialog" class="modal">
            <div class="modal-dialog">
                <div class="modal-content" style="padding: 20px;">
                    <div class="dialog-message-title">
                      <h3 class="modal-title" style="width:90%; display:block; float: left;">Edit Message</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  
                  <a href="" class="btn btn-success" id="dialogEditSuccess" style="display:none;">You has updated the message successfully</a>
                  <a href="" class="btn btn-danger" id="dialogEditError" style="display:none;">Can not update guest message</a>
                  
                  
                  <div class="dialog-message-form">
                      <form action="#" onclick="return false;">
                          <fieldset class="form-group">
                            <label for="dialogEditName" style="color: blue;">Guest name <span style="color: red;">*</span></label>
                            <input type="hidden" id="dialogEditId" />
                            <input type="text" class="form-control" id="dialogEditName" disabled="disabled"/>
                          </fieldset>
                          <fieldset class="form-group">
                               <fieldset class="form-group">
                                <label for="dialogEditMessage" style="color: blue;">Guest Message<span style="color: red;">*</span></label>
                                <textarea class="form-control" id="dialogEditMessage" rows="3" placeholder="Input your message"></textarea>
                              </fieldset>
                          </fieldset>
                          <fieldset style="text-align: center;">
                            <button type="submit" id="dialogEditSubmit" class="btn btn-primary mb-2" style="text-align: center;">Edit</button>
                          </fieldset>
                      </form>
                  </div>
                </div>
            </div>
        </div>
        
        <!-- Delete Message Dialog s-->
        <div id="delete-dialog" class="modal">
            <div class="modal-dialog">
                <div class="modal-content" style="padding: 20px;">
                    <div class="dialog-message-title">
                      <h3 class="modal-title" style="width:90%; display:block; float: left;">Are You sure you want to delete?</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <a href="" class="btn btn-success" id="dialogDeleteSuccess" style="display:none;">You has deleted the message successfully</a>
                  <a href="" class="btn btn-danger" id="dialogDeleteError" style="display:none;">Can not delete guest message</a>
                  
                  <div class="dialog-message-form">
                      <form action="#" onclick="return false;">
                          <fieldset style="text-align: center;">
                            <input type="hidden" id="dialogDeleteId" />
                            <button type="submit" id="dialogDeleteSubmit" class="btn btn-primary mb-2" style="text-align: center;">OK</button>
                            </fieldset>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>