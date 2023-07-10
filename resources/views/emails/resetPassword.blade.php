<!DOCTYPE>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
      body {
          background: #F1F3F4;
          width: 100%;
          height: auto;
          margin: 0 auto;
          padding: 3% 0px;
          font-family: 'Open Sans', sans-serif;
          overflow-x: hidden;
      }

      section {
          background: white;
          border-radius: 30px;
          max-width: 540px;
          margin: 50px auto;
          width: 90%;
          box-shadow: 2px 2px 3px #afafaf;
      }

      div {
          padding: 25px 50px;
          text-align: justify;
      }

      p {
          color: #2C2B2C;
          letter-spacing: 0px;
          font-size: 16px;
          line-height: 22px;
          overflow-wrap: anywhere;
      }

      .bt-social {
          border-radius: 50%;
          text-decoration: none;
          display: flex;
          padding: 10px;
          justify-content: center;
          align-items: center;
          margin-right: 10px;
      }

      /* BOTÃO REDE SOCIAL */
      .bt {
          color: #0081E6;
          padding: 14px 26px;
          border: 2px solid #0081E6;
          border-radius: 5px;
          text-decoration: none;
          font-weight: 600;
      }

      /* BOTÃO PARA SOLICITAR REEMBOLSO */
      .bt:hover {
          background: #cce6fa;
      }

      /* TROCA DE COR DO BOTÃO PARA MOUSE HOVER */
      .email {
          color: #2C2B2C;
          text-decoration: none;
      }

      /* ESTILO PARA DEFINIR O LINK MALITO E MANTER MESMA FORMATAÇÃO DE TEXTO SENDO POSSIVEL CLICAR E ABRIR A CAIXA DE ENVO DE EMAIL */
      .small {
          font-size: 12px;
          color: #808080;
      }

      /* PRIMEIRO ITEM DE LI PARA DEFINIR O TEXTO CINZA PEQUENO */
      ul {
          list-style: none;
          padding: 0;
          margin: 15px 0px;
      }

      li {
          color: #333333;
          font-weight: 600;
      }

      /* ESTILO DE TODOS OS SEGUNDOS ITENS LI */
      .logo {
          display: flex;
          border-radius: 30px 30px 0 0;
          justify-content: center;
          padding: 50px 0px;
          background-color: #2C2B2C;
      }

      /* ESTILO DA LOGO */
  </style>
</head>
<body>
<section>
  <div class="logo">
    <img src="https://api2.abmex.com.br/public/images/abmex-logo.svg" alt="Abmex"/>
  </div>
  <div style="background: #FBFBFB;">
    <p>Olá, <strong>{{ $user->name }}</strong>!!</p>
    <p>Parece que voc&ecirc; esqueceu sua senha? N&atilde;o tem problema, vou te ajudar!!</p>
    <p>Para cadastrar uma nova senha, basta clicar no botão abaixo:</p>
    <br/>
    <br/>
    <a href="https://app.abmex.com.br/remember/{{ $token }}" target="_blank" class="bt">RECUPERAR SENHA</a>
    <br/>
    <br/>
    <br/>
    <p>Caso você não tenha solicitado um recadastramento de senha, basta desconsiderar este email!</p>
    <p>Um abraço da equipe ABMEX!</p>
  </div>
  <div style="padding-bottom: 64px;">
    <hr>
    <p>Siga @abmex no Instagram, Facebook e YouTube para ter acesso aos conteúdos e novidades da plataforma.</p>
    <div style="display: flex; padding: 0">
      <a
          href="https://www.instagram.com/abmexoficial/"
          target="_blank"
          class="bt-social"
      >
        <img
            src="https://abmex-bucket.s3.sa-east-1.amazonaws.com/f9816282492e3f0746d46a2b24cbccef.png"
            alt="Instagram"
            style="height: 35px; width: 35px"
        />
      </a>
      <a
          href="https://www.facebook.com/abmexoficial"
          target="_blank"
          class="bt-social"
      >
        <img
            src="https://abmex-bucket.s3.sa-east-1.amazonaws.com/673f4ef37926aba6bdb095e56a525da1.png"
            alt="Facebook"
            style="height: 35px; width: 35px"
        />
      </a>
    </div>
  </div>
</section>
</body>
</html>