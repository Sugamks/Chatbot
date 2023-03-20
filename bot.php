<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot in PHP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        html,body{
            display: grid;
            height: 100%;
            place-items: center;
        }
        ::selection{
            color: #fff;
            background: #47555c;
        }
        ::-webkit-scrollbar{
            width: 3px;
            border-radius: 25px;
        }
        ::-webkit-scrollbar-track{
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb{
            background: #ddd;
        }
        ::-webkit-scrollbar-thumb:hover{
            background: #ccc;
        }
        .wrapper{
            width: 370px;
            background: #fff;
            border-radius: 5px;
            border: 1px solid lightgrey;
            border-top: 0px;
        }
        .wrapper .title{
            background:#47555c;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            line-height: 60px;
            text-align: center;
            border-bottom: 1px solid #47555c;
            border-radius: 5px 5px 0 0;
        }
        .wrapper .form{
            padding: 20px 15px;
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
        }
        .wrapper .form .inbox{
            width: 100%;
            display: flex;
            align-items: baseline;
        }
        .wrapper .form .user-inbox{
            justify-content: flex-end;
            margin: 13px 0;
        }
        .wrapper .form .inbox .icon{
            height: 40px;
            width: 40px;
            color: #fff;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            font-size: 18px;
            background: #47555c;
        }
        .wrapper .form .inbox .msg-header{
            max-width: 57%;
            margin-left: 10px;
        }
        .form .inbox .msg-header p{
            color: #fff;
            background: #47555c;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 14px;
            word-break: break-word;
        }
        .form .user-inbox .msg-header p{
            color: #333;
            background: #efefef;
        }
        .wrapper .typing-field{
            display: flex;
            height: 60px;
            width: 100%;
            align-items: center;
            justify-content: space-evenly;
            background: #efefef;
            border-top: 1px solid #d9d9d9;
            border-radius: 0 0 5px 5px;
        }
        .wrapper .typing-field .input-data{
            height: 40px;
            width: 335px;
            position: relative;
        }
        .wrapper .typing-field .input-data input{
            height: 100%;
            width: 100%;
            outline: none;
            border: 1px solid transparent;
            padding: 0 80px 0 15px;
            border-radius: 3px;
            font-size: 15px;
            background: #fff;
            transition: all 0.3s ease;
        }
        .typing-field .input-data input:focus{
            border-color: #47555c;
        }
        .input-data input::placeholder{
            color: #999999;
            transition: all 0.3s ease;
        }
        .input-data input:focus::placeholder{
            color: #bfbfbf;
        }
        .wrapper .typing-field .input-data button{
            position: absolute;
            right: 5px;
            top: 50%;
            height: 30px;
            width: 65px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            opacity: 0;
            pointer-events: none;
            border-radius: 3px;
            background: #47555c;
            border: 1px solid #47555c;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }
        .wrapper .typing-field .input-data input:valid ~ button{
            opacity: 1;
            pointer-events: auto;
        }
        .typing-field .input-data button:hover{
            background: #47555c;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="title">Simple Online Chatbot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                    <button onclick="fees()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Fees</button>
                    <button onclick="exams()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Exam</button>
                    <button onclick="transport()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Transportation</button>
                </div>
            </div>

        </div>
        <div class="typing-field">
            <div class="input-data">
                <input name="data" id="data" type="text" placeholder="Type something here.." required>
                <button type="submit" id="send-btn" >Send</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p style="maxlength:16">'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                if($value === "fees"){
                    fees();
                }
                else if($value === "exams"){
                    exams();
                }
                else if($value ==="transport"){
                    transport();
                }
                else{
                // start ajax code
                $.ajax({
                    url: 'message.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        // $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            }
            });
        });
        function fees(){
            $var = `
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Fees related Options are.</p>
                    <button onclick="unable()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">unable to pay fees</button>
                    <button onclick="debit()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Money debited but receipt not generated</button>
                </div>
            </div>
            `;
            $(".form").append($var);
        }
        function unable(){
            $var = `
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                <p>Enter the details to check the payment</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Student ID" name="sid" id="sidu">
                    <button class="btn btn-outline-secondary" type="submit" id="submitu">Submit</button>
                </div>
                </div>
            </div>
            `;
            $(".form").append($var)
            $(document).ready(function(){
            $("#submitu").on("click", function(){
                $value = $("#sidu").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p style="maxlength:16">'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#sid").val('');
                
                // start ajax code
                $.ajax({
                    url: 'unable.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>Thank you. Your Complaint id is : '+ result +' . Our support team will get back to you within 24 hrs.</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
        }
        function debit(){
            $var= `
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                <p>Enter the details to verify your transaction</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Student ID" id="sidd">
                    <button class="btn btn-outline-secondary" type="submit" id="submitdeb">Submit</button>
                </div>
                </div>
            </div>
            `;
            $(".form").append($var);
            $(document).ready(function(){
            $("#submitdeb").on("click", function(){
                $value = $("#sidd").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p style="maxlength:16">'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#sid").val('');
                
                // start ajax code
                $.ajax({
                    url: 'debit.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>Thank you. Your Complaint id is : '+ result +' . Your Complaint will be resolved in 24 hrs.</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
        }
        function exams(){
            $var =`
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>exams</p>
                    <button onclick="update()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Portions</button>
                </div>
            </div>
            `;
            $(".form").append($var)
        }
        function transport(){
            $var = `
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>transport</p>
                    <button onclick="update()" class="btn btn-outline-secondary" style="margin-bottom: 5px;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Routes</button>
                </div>
            </div>
            `;
            $(".form").append($var)
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>