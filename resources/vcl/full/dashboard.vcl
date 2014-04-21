#test
vcl 4.0;

backend server1 {
  .host = "localhost";
  .probe = {
         .url = "/";
         .interval = 5s;
         .timeout = 1 s;
         .window = 5;
         .threshold = 3;
    }
  }
