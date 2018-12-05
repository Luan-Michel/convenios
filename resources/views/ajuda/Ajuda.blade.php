@extends('app')

@section('content')

        <h1>Ajuda</h1>

        <div>
          <div style="padding: 20px" id="financiador">
            <h2> Financiador </h2>
            A página de financiadores é dedicada para o agrupamento de todos os financiadores presentes no sistema. Ela apresenta o nome e a sigla com os quais um financiador foi cadastrado e a esfera em que pertence.
            A lista apresenta um total de 10 financiadores por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de financiadores apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de financiadores na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um financiador no sistema. Insira o nome ou apelido com os quais você acredita que um financiador possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de um financiado no sistema, consulte as seções abaixo. Para vinculação de um financiador a um convênio, consulte a página de ‘Convênios’ nesse manual.

            <h4>Cadastro</h4>
            Para cadastrar um financiador no sistema, clique em um dos botões [Novo] que aparecem nos cantos superior e inferior da página de Financiador. Você será redirecionado para a página de cadastro.
            No campo ‘Nome’ é recomendada a inserção da identificação real do financiador. Caso ela seja muito
            comprida, utilize o campo ‘Sigla’ e insira um apelido pelo qual o financiador será também referenciado.
            A esfera a qual um financiador pertence não pode ser manipulada de forma manual. Você deve escolher
            dentre as opções ‘Municipal’, ‘Estadual’, ‘Federal’ e ‘Internacional’ disponíveis em uma lista no campo
            ‘Esfera’.
            Após preencher os campos obrigatórios, clique no botão [Salvar] para inserir um financiador no sistema.
            Caso tenha preenchido um campo de forma incorreta e o financiador tenha sido cadastrado, altere-o
            (consulte a próxima seção para detalhes quanto a modificação de financiadores); todos os campos podem
            ser alterados posteriormente e você poderá corrigir algum erro. Caso algum erro tenha sido gerado na
            tentativa de inserção do financiador no sistema, o cadastro não será efetivado e recomenda-se a leitura do
            erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um financiador, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao financiador que deseja
            modificar. Nessa página você poderá alterar manualmente o nome e a sigla vinculados a ele.
            Deixe o campo ‘Sigla’ em branco caso queira excluir um apelido vinculado a um financiador.
            Clique no botão [Salvar] para salvar alterações realizadas. Toda alteração que não for salva através desse
            botão será perdida. Caso algum erro tenha sido gerado na tentativa de Alteração do financiador, as alterações
            não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua um financiador do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ele. Essa opção remove o registro para vinculações a convênios.
            Se um financiador estiver vinculado a um convênio, estejam esses ativos ou não, ele não poderá ser removido do sistema.

          </div>
          <div style="padding: 20px" id="categoria">
            <h2> Categoria de Convênio </h2>
            A página de categorias de convênio é dedicada para o agrupamento de todas as categorias nas quais um convênio pode ser vinculado.
            A lista apresenta um total de 10 categorias por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de categorias apresentadas por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de categorias na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar uma categoria no sistema. Insira o nome com o qual você acredita que uma categoria possa ter sido cadastrada e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de uma categoria no sistema, consulte as seções abaixo. Para vinculação de uma categoria a um convênio, consulte a página de ‘Convênios’ nesse manual.

            <h4>Cadastro</h4>
            Para cadastrar uma categoria no sistema, clique em um dos botões [Novo] que aparecem nos cantos superior e inferior da página de Categoria de convênio. Você será redirecionado para a página de cadastro.
            O campo ‘Nome’, único requerido para inserção de uma nova categoria, deve estar preenchido para que um cadastro seja realizado. É recomendada a inserção de frases curtas e significativas para a identificação de uma categoria.
            Após preencher o campo obrigatório, clique no botão [Salvar] para inserir uma categoria no sistema.
            Caso tenha preenchido o campo de forma incorreta e a categoria tenha sido cadastrada, altere-a (consulte a próxima seção para detalhes quanto a modificação de categorias já cadastradas). Caso algum erro tenha sido gerado na tentativa de inserção da categoria no sistema, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar uma categoria, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto a categoria que deseja modificar. Nessa página você poderá alterar manualmente o nome vinculado a categoria. Não é permitido o não preenchimento desse campo.
            Clique no botão [botão] para salvar a alteração realizada. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração da categoria, a alteração não será efetivada e recomenda-se a leitura do erro apresentado para a validação dessa.

            <h4>Exclusão</h4>
            Exclua uma categoria do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ele. Essa opção remove o registro para vinculações a convênios.
            Se uma categoria estiver vinculada a um convênio, estejam esses ativos ou não, ela não poderá ser removida do sistema.
          </div>
          <div style="padding: 20px" id="convenio">
            <h2>Convênio</h2>
            A página de convênios é destinada ao armazenamento de todos os convênios cadastrados no sistema. Ela apresenta um breve resumo dos convênios através de suas informações mais relevantes como ano, número, financiador e sigla. Para visualizar toda a informação referente a um convênio, basta clicar sobre qualquer um dos campos anteriormente mencionados desse. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 convênios por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de convênios apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de convênios na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um convênio no sistema. Insira o número ou apelido com os quais você acredita que um convênio possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de um convênio no sistema, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para cadastrar um convênio no sistema, clique em um dos botões [Novo] que aparecem nos cantos superior e inferior da página de Convênio. Você será redirecionado para a página de cadastro.
            Recomenda-se redobrada atenção no preenchimento dos campos de inserção de um convênio. Muitos deles não são alteráveis, o que significa que não poderão ser alterados após seu cadastro.
            Preencha manualmente os campos numéricos ‘Número’, ‘Ano’ e ‘Número do protocolo’ do convênio. Essas informações serão utilizadas para a referenciação de um convênio. O campo ‘Número’ refere-se ao código oficial do convênio e o campo ‘Número do protocolo’ refere-se ao número do protocolo gerado a esse convênio. Preencha o campo ‘Ano’ com o ano em que o convênio foi gerado. Esses campos não são alteráveis.
            O campo ‘Sigla do objeto’ é utilizado como referenciação ao campo de ‘Objeto’ do convênio caso esse seja demasiado longo. Ambos se referem ao objeto do convênio. Ambos os campos permitem modificação posterior.
            Insira no campo ‘SIT’ o número do convênio junto ao Tribunal de Contas do Estado. Essa informação não é alterável.
            Insira o investimento total atribuído ao convênio no campo ‘Valor’. A moeda utilizada nesse campo é o real. Esse campo não é alterável.
            As datas de início, limite de execução, prestação de contas e limite de vigência são requeridas nos campos de respectivas identificações. Assegure-se de que as datas não se sobreponham. Esses campos não são alteráveis. Adicione um termo aditivo a um convênio caso seu limite de execução, vigência ou prestação de contas tenham sido alterados (consulte a página de ‘Termo Aditivo’ para detalhes).
            Os campos ‘Financiador’, ‘Categoria’, ‘Conta Contábil – Plano’ e ‘Conta Contábil – Banco’ não podem ser manipulados de forma manual. Os valores devem ser escolhidos da lista apresentada em cada campo. É possível adicionar novos financiadores e categorias para vinculação a um convênio no cadastro de ‘Financiador’ e ‘Categoria de convênio’ (consulte o manual das páginas para detalhes). A inserção de novos registros para os campos ‘Conta Contábil – Plano’ e ‘Conta Contábil – Banco’, porém, não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI. Vincule nos respectivos campos o financiador investindo no convênio, a categoria na qual ele pertence e as contas utilizadas por ele. Altere-as posteriormente caso seja necessário.
            O campo ‘Resumo do Plano de Trabalho’ não possui limite de caractere e pode ser alterado a qualquer momento. Preencha-o com um parecer quanto ao planejamento do convênio.
            No campo ‘Anexo’ são permitidas vinculação de documentos nos formatos […] a um convênio. Utilize o botão [botão] para selecioná-lo de seu computador. A remoção desses documentos é permitida após submissão.
            Após preencher os campos obrigatórios, clique no botão [botão] para inserir um convênio no sistema.
            Caso tenha preenchido um campo de forma incorreta e o convênio tenha sido cadastrado, altere-o (consulte a próxima seção para detalhes quanto a modificação de convênios); Caso tenha preenchido algum campo de forma incorreta e o prévio empenho tenha sido cadastrado, altere-a (consulte a próxima seção para detalhes quanto a modificação de prévios empenhos). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua o convênio imediatamente (consulte a próxima seção para detalhes quanto a exclusão de convênios) e recrie-o corretamente. Caso isso não seja possível (isso é, o convênio já está sendo utilizado dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na tentativa de inserção do convênio no sistema, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um convênio, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao convênio que deseja modificar. Nessa página você poderá alterar campos não protegidos vinculados a ele.
            Deixe campos não obrigatórios em branco caso queira excluir seus conteúdos.
            Remova um documento vinculado a um convênio clicando no ícone <span class="glyphicon glyphicon-trash"></span> junto a ele.
            Clique no botão [Salvar] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração do convênio, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua um convênio do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ele. Essa opção remove todas as informações e documentos vinculados a um convênio.
            Se um convênio possuir registros dependentes ou estiver vinculado a um prévio empenho ou termo aditivo ele não poderá ser removido do sistema.
          </div>
          <div style="padding: 20px" id="previoempenho">

            <h2>Prévio Empenho</h2>
            A página de prévios empenhos é dedicada para o agrupamento de todas os prévios empenhos vinculados a convênios. Ela apresenta um breve resumo dos prévios empenhos através de suas informações mais relevantes como ano, número, financiador e beneficiário. Para visualizar toda a informação referente a um prévio empenho, basta clicar sobre qualquer um dos campos anteriormente mencionados desse. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 prévios empenhos por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de prévios empenhos apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de prévios empenhos na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um prévio empenho no sistema. Insira o ano ou número com os quais você acredita que um prévio empenho possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de um prévio empenho no sistema, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para cadastrar um prévio empenho no sistema, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Prévio Empenho. Você será redirecionado para a página de cadastro.
            Recomenda-se redobrada atenção no preenchimento dos campos de inserção de um prévio empenho. Muitos deles não são alteráveis, o que significa que não poderão ser alterados após seu cadastro.
            É necessária a vinculação de um convênio a todo prévio empenho cadastrado. Essa vinculação é realizada através dos campos ‘Ano do convênio’, ‘Número do Convênio’ e ‘Etapa aplicação’ onde opções serão apresentadas para seus preenchimentos. Todas essas informações são pertencentes ao convênio cuja vinculação será gerada e nenhuma delas pode ser manipulada de forma manual. É possível adicionar novos convênios para vinculação a um prévio empenho no cadastro de ‘Convênio’ (consulte o manual das páginas para detalhes). Após cadastro do prévio empenho, a alteração de um convênio através desses campos não é mais permitida.
            Insira o ano e o número do prévio empenho nos respectivos campos numéricos. No campo ‘Ano do prévio’ utilize o ano em que o prévio empenho foi gerado. No campo ‘Número do prévio’ utilize […]. Esses campos não são alteráveis.
            Utilize o formato dd/mm/aaaa na inserção da data do prévio empenho no campo ‘Data do prévio’. Utilize a data de quando esse foi gerado e respeite o limite imposto pelo convênio ao qual está vinculado. Esse campo não é alterável.
            Insira no campo numérico ‘Valor do prévio’ o valor estimado no prévio empenho. Esse valor deve estar dentro do limite imposto pelo convênio ao qual o prévio empenho está vinculado. Sua alteração não é permitida após cadastro. Escolha o tipo da moeda utilizada no campo alterável ‘Moeda’. Esse não pode ser manipulado de forma manual e a inserção de novo tipo de moeda não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI.
            O campo ‘Financiador’ se refere ao financiador do prévio empenho de um convênio. Não é obrigatório que esse campo seja preenchido com o financiador vinculado ao convênio objeto. Atente ao escolher dentre os financiadores apresentados no campo – o campo não pode ser manipulado de forma manual e não é alterável. É possível adicionar novos financiadores para vinculação a um prévio empenho no cadastro de ‘Financiador’ (consulte o manual das páginas para detalhes).
            Os campos ‘Tipo compra’ e ‘Fonte’ se referem aos gastos planejados com o prévio empenho e apresentam opções para preenchimento. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI. Ambos são não alteráveis.
            Os campos ‘Tipo beneficiário’, ‘Nome beneficiário’ e ‘Conta Corrente’ se referem todos ao beneficiário vinculado ao prévio empenho e é necessária a vinculação do beneficiário ao convênio sobre o qual o prévio empenho é aplicável. A manipulação manual desses campos não é permitida e a inserção de novos registros nas listas apresentadas não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI.
            O campo ‘Objetivo do Prévio’ é utilizado para inserção de parecer quanto a utilização do prévio empenho. O campo não possui limite de caractere e pode ser alterado posteriormente.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular um prévio empenho a um convênio.
            Caso tenha preenchido algum campo de forma incorreta e o prévio empenho tenha sido cadastrado, altere-o (consulte a próxima seção para detalhes quanto a modificação de prévios empenhos). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua o prévio empenho imediatamente (consulte a próxima seção para detalhes quanto a exclusão de prévios empenhos) e recrie-o corretamente. Caso isso não seja possível (isso é, o prévio empenho já está sendo utilizado dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na tentativa de vinculação do prévio empenho a um convênio, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um prévio empenho, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao prévio empenho que deseja modificar. Nessa página você poderá alterar campos não protegidos vinculados a ele.
            Deixe campos não obrigatórios em branco caso queira excluir seus conteúdos.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração do prévio empenho, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua um prévio empenho do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ele. Essa opção remove todas as informações referentes a um prévio empenho do sistema e, consequentemente, o desvincula de um convênio.
            Se qualquer registro estiver vinculado a um prévio empenho, estejam esses ativos ou não, ele não poderá ser removido do sistema.
          </div>
          <div style="padding: 20px" id="pessoa">

            <h2>Pessoa</h2>
            A página de pessoas é dedicada para o agrupamento de todos as pessoas presentes no sistema. Ela apresenta o nome e a identificação legal com os quais uma pessoa foi cadastrada.
            Utilize o campo de pesquisa situado no canto superior esquerdo da tela para encontrar uma pessoa no sistema. Insira o nome ou apelido com os quais você acredita que ela possa ter sido cadastrada e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de uma pessoa no sistema, consulte as seções abaixo. Para vinculação de uma pessoa a um convênio, consulte a página de ‘Participantes’ nesse manual.

            <h4>Cadastro</h4>
            Existem dois métodos para cadastro de pessoas dentro do sistema. Clique no botão [botão pessoa física] caso a pessoa sendo cadastrada seja uma pessoa física e [botão pessoa jurídica] caso essa seja uma pessoa jurídica. Você será redirecionado para a página de cadastro correta a partir de sua escolha.

            <h4>Pessoa Física</h4>
            Preencha os campos ‘Nome Completo’ e ‘Nome Abreviado’ com o nome real e apelido das pessoas sendo cadastradas, respectivamente. O apelido será utilizado para referenciação ao nome real.
            O campo ‘CPF’ exige o número regularizado da pessoa junto a receita federal. Esse campo não é alterável. Utilize a formatação sendo recomendada no campo.
            Insira o endereço de correio eletrônico vinculado a pessoa no campo ‘Email’. Utilize o botão [botão] para adicionar mais endereços e o botão [botão] para remover algum endereço. Ambos podem ser utilizados a qualquer momento.

            <h4>Pessoa Jurídica</h4>
            O campo ‘Nome Fantasia’ exige o nome de identificação da pessoa jurídica. Ele, junto a identificação na receita federal, será utilizado para referenciação a pessoa cadastrada.
            Preencha os campos ‘CNPJ’ e ‘Inscrição estadual’ com os respectivos números da pessoa jurídica regularizados junto a receita federal. Utilize as formatações sendo recomendadas nos campos. Esses  não poderão ser modificados posteriormente.
            O campo ‘CD  siaf’ […].
            O campo ‘Email’  se comporta da mesma forma que o apresentado na inserção de pessoas físicas:  Insira o endereço de correio eletrônico vinculado a pessoa nesse campo. Utilize o botão [botão] para adicionar mais endereços e o botão [botão] para remover algum endereço. Ambos podem ser utilizados a qualquer momento.

            Após preencher os campos obrigatórios, clique no botão [botão] para inserir uma pessoa no sistema.
            Caso tenha preenchido algum campo de forma incorreta e a pessoa tenha sido cadastrada, altere-a (consulte a próxima seção para detalhes quanto a modificação de pessoas). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua a pessoa imediatamente (consulte a próxima seção para detalhes quanto a exclusão de pessoas) e recrie-a corretamente. Caso isso não seja possível (isso é, a pessoa já está sendo utilizada dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na tentativa de inserção da pessoa no sistema, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar uma pessoa, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto a pessoa que deseja modificar. Nessa página você poderá alterar manualmente o nome e o nome abreviado vinculados ao registro de uma pessoa física ou apenas o nome caso esse seja de uma pessoa jurídica. Os outros campos são protegidos e não podem ser modificados.
            A alteração de um endereço de correio eletrônico não é permitida. Remova um endereço incorreto através do botão [botão] junto ao endereço e adicione-o corretamente.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração da pessoa, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua uma pessoa do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ela. Essa opção remove a pessoa para vinculações a convênios.
            Se uma pessoa estiver vinculada a um convênio, estejam esses ativos ou não, ela não poderá ser removida do sistema.
          </div>
          <div style="padding: 20px" id="participante">
            <h2>Participante</h2>
            A página de participantes é dedicada para o agrupamento de todas as pessoas vinculadas a convênios. Ela apresenta um breve resumo dos vínculos através de suas informações mais relevantes como o participante, sua instituição e o convênio. Para visualizar toda a informação referente a um participante, basta clicar sobre qualquer um dos campos anteriormente mencionados desse. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 participantes por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de participantes apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de participantes na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um participante no sistema. Insira o nome, número do convênio ou instituição com os quais você acredita que um participante possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de participantes no sistema, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para cadastrar um participante no sistema, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Participante. Você será redirecionado para a página de cadastro.
            Selecione o participante para vincular a um convênio no campo ‘Nome’. Você pode manipular esse campo manualmente, mas um participante só será aceito se existir no sistema. Busque uma pessoa para ser participante de um convênio através do botão [botão]. Confira se uma pessoa é apta a ser participante de um convênio através do botão [botão]. Caso um participante não esteja presente no sistema, adicione-a através dos dois botões no canto inferior esquerdo da tela. Utilize o botão [botão] caso o participante seja uma pessoa seja física e o botão [botão] caso o participante seja uma pessoa jurídica. Esse campo é alterável e pode ser modificado posteriormente.
            É necessária a vinculação de um convênio a todo participante cadastrado. Essa vinculação é realizada através do campo ‘Convênio’. O campo não pode ser manipulado de forma manual e um convênio já cadastrado deve ser escolhido. É possível adicionar novos convênios para vinculação de um participante no cadastro de ‘Convênio’ (consulte o manual das páginas para detalhes). Após cadastro de participante, a alteração de um convênio através desse campos não é mais permitida.
            Informe se um participante é coordenador do convênio do vínculo através do campo ‘Coordenador’. Marque a opção ‘Sim’ se ele é e ‘Não’ se ele não é. Você pode alterar essa resposta a qualquer momento.
            O campo ‘Categoria’ apresenta categoria nas quais um participante se encaixa. O campo não pode ser manipulado de forma manual e deve ser escolhida uma opção dentre as apresentadas. A inserção de novos registros na lista apresentada não é suportada. Caso seja necessária a inserção de novos registros a esse campo, contate o NTI.
            Os campos ‘Instituição’ e ‘CNPJ-Instituição’ se referem a instituição a qual o participante está vinculado. Insira o nome na instituição no campo ‘Instituição’ e seu número de CNPJ junto a receita federal no campo ‘CNPJ-Instituição’. Utilize para o segundo a formatação recomendada no campo. Ambos são alteráveis.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular um participante a um convênio.
            Caso tenha preenchido algum campo de forma incorreta e o participante tenha sido cadastrado, altere-o (consulte a próxima seção para detalhes quanto a modificação de participantes). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua o participante imediatamente (consulte a próxima seção para detalhes quanto a exclusão de participantes) e recrie-o corretamente. Caso isso não seja possível (isso é, o participante já está sendo utilizado dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na vinculação de um participante a um convênio, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um participante, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao participante que deseja modificar. Nessa página você poderá alterar a pessoa, a categoria em que ela pertence, seu papel dentro do convênio e suas informações de instituição. O campo de convênio é protegido e não pode ser modificado.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração de participante, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua um participante do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ele. Essa opção remove todas as informações referentes a um participante e desvincula sua relação com um convênio. As informações de pessoa do participante permanecem no sistema.
            Se um participante for coordenador de um convênio, estejam esses ativos ou não, ele não poderá ser removido do sistema.
          </div>
          <div style="padding: 20px" id="plano_de_trabalho">

            <h2>Plano de trabalho</h2>
            A página de plano de trabalho é dedicada para o agrupamento de todas as metas vinculadas a convênios no sistema. Ela apresenta o título e a sequência de uma meta dentro de um convênio. Para visualizar toda a informação referente a uma meta, basta clicar sobre qualquer um dos campos anteriormente mencionados dessa. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            É possível visualizar os planos de trabalho de apenas um convênio. Acesse-o através do botão [botão] no canto esquerdo da página informativa do convênio. Encontre o apelido do convênio de um plano de trabalho no canto superior direito da tela.
            A lista apresenta um total de 10 metas por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de metas apresentadas por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de metas na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar uma meta vinculada ao convênio atual. Insira a titulação ou número de sequência com os quais você acredita que uma meta possa ter sido cadastrada e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de plano de trabalho de um convênio, consulte as seções abaixo.

            <h4>Cadastro</h4>
            A inserção de metas só é disponível dentro do plano de trabalho de um convênio. Para vincular uma nova meta ao convênio, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Plano de trabalho de um convênio. Você será redirecionado para a página de cadastro. O campo de vinculação da meta ao convênio será preenchido automaticamente e não poderá ser alterado.
            O campo ‘Sequência meta aplicação’ se refere a ordem da meta dentro do plano de trabalho do convênio. Não é obrigatório que uma sequência seja mantida nessa inserção, mas ela é recomendada para uma melhor organização dentro do plano de trabalho. O campo é numérico e alterável.
            Insira a titulação da meta no campo ‘Título meta aplicação’. Junto ao número de sequência, esse campo define a identificação da meta dentro do plano de trabalho do convênio. Você poderá alterá-lo posteriormente.
            Os campos ‘Início da meta’ e ‘Término da meta’ se referem ao período estipulado para a aplicação de uma meta. Insira a data quando ela será iniciada e terminada, respectivamente, respeitando o limite imposto pelo convênio ao qual está vinculada. Utilize a formatação recomendada nos campos (dd/mm/aaaa). Esses campos não são alteráveis.
            O campo ‘Meta aplicação’ é destinado para um resumo quanto aos objetivos da meta. Altere-o a qualquer momento.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular uma meta ao convênio.
            Caso tenha preenchido algum campo de forma incorreta e a meta tenha sido cadastrada, altere-a (consulte a próxima seção para detalhes quanto a modificação de metas). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua a meta imediatamente (consulte a próxima seção para detalhes quanto a exclusão de metas) e recrie-a corretamente. Caso isso não seja possível (isso é, a meta já está sendo utilizada dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na vinculação de uma meta a um plano de trabalho de convênio, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um participante, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao participante que deseja modificar. Nessa página você poderá alterar manualmente a titulação, o resumo e a sequência da meta do plano de trabalho. Os outros campos são protegidos e não podem ser modificados.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração de meta, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua uma meta do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ela. Essa opção remove todas as informações referentes a uma meta e desvincula sua relação com um convênio em um plano de trabalho.
            Se uma meta possuir uma etapa, estejam essas ativas ou não, ela não poderá ser removida do plano de trabalho do convênio.

          </div>
          <div style="padding: 20px" id="etapa_plano_de_trabalho">

            <h2>Etapa do plano de trabalho</h2>
            A página de etapas de plano de trabalho é dedicada para o agrupamento de todas as etapas vinculadas a planos de trabalho de convênios. Ela apresenta um breve resumo das etapas através de suas informações mais relevantes como título, número, seu plano de trabalho e a data de seu término. Para visualizar toda a informação referente a uma etapa, basta clicar sobre qualquer um dos campos anteriormente mencionados dessa. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 etapas por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de etapas apresentadas por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de etapas na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar uma etapa no sistema. Insira o título da etapa ou título da meta com os quais você acredita que uma etapa possa ter sido cadastrada e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de uma etapa a uma meta de convênio, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para inserir uma etapa a uma meta, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Etapa de plano de trabalho. Você será redirecionado para a página de cadastro.
            É necessária a vinculação de uma meta a toda etapa cadastrada. Essa vinculação é realizada através do campo ‘Plano de trabalho’ onde uma lista de metas será apresentada para seu preenchimento. É possível adicionar novas metas para vinculação a uma etapa no cadastro de ‘Plano de trabalho’ (consulte o manual das páginas para detalhes). Após cadastro de uma etapa, a alteração de sua meta através desse campo não é mais permitida.
            O campo ‘CDRED’ não é manipulável de forma manual. Escolha dentre as opções o […]. A inserção de novos registros na lista apresentada não é suportada. Caso seja necessária a inserção de novos registros a esse campo, contate o NTI. Após cadastro de etapa, esse campo não poderá ser alterado.
            Expresse a categoria das despesas da etapa através do campo ‘Despesas’. Escolha dentre as opções a que melhor representa os gastos da etapa. A inserção de novos registros na lista apresentada não é suportada. Caso seja necessária a inserção de novos registros a esse campo, contate o NTI. O campo pode ser alterado após cadastro.
            Insira o título da etapa no campo ‘Título da Etapa’. O texto inserido será utilizado para referenciar a etapa sendo cadastrada. Altere-o quando necessário.
            O campo ‘Etapa’ é reservado para o resumo dos objetivos da etapa. O campo não possui limite de caracteres é pode ser alterado a qualquer momento.
            Insira a data estipulada para o início da etapa no campo ‘Data de Início’ e a data estipulada para o fim da etapa no campo ‘Data de Término’. Utilize a formatação recomendada nos campos (dd/mm/aaaa) e respeite o limite imposto pela meta ao qual está vinculada. Esses campos não são alteráveis e, portanto, não poderão ser alterados após cadastro de meta.
            Utilize o campo numérico ‘Quantidade Unidade’ para inserir a quantidade de material adquirido na etapa. Se mais aplicável, utilize o campo ‘Unidade Medida’ para expressar essa informação. Esses campos não são alteráveis. No campo ‘Unidade Medida’, preencha com […].
            Existem quatro campos referentes ao valor investido na etapa. Insira o valor utilizado na etapa no campo ‘Valor total’. Insira o valor […] no campo ‘Valor Reservado’. Insira o valor empenhado para a etapa no campo ‘Valor empenhado’ e insira o valor […] no campo ‘Valor Saldo’. Utilize a moeda real em todos os campos e respeite os limites impostos pelo convênio ao qual a etapa está vinculada através do plano de trabalho. Esses campos não são alteráveis.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular uma etapa ao plano de trabalho de um convênio.
            Caso tenha preenchido algum campo de forma incorreta e a etapa tenha sido cadastrada, altere-a (consulte a próxima seção para detalhes quanto a modificação de etapas). Caso algum campo protegido tenha sido preenchido de forma incorreta, exclua a etapa imediatamente (consulte a próxima seção para detalhes quanto a exclusão de etapas) e recrie-ao corretamente. Caso isso não seja possível (isso é, a etapa já está sendo utilizada dentro do sistema) contate o NTI. Caso algum erro tenha sido gerado na tentativa de vinculação da etapa a meta de um convênio, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um prévio empenho, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao prévio empenho que deseja modificar. Nessa página você poderá alterar os campos de titulação da etapa, categoria das despesas geradas e o resumo de objetivos. Os outros campos são protegidos e não podem ser modificados.
            Deixe campos não obrigatórios em branco caso queira excluir seus conteúdos.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração da etapa, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua uma etapa do sistema clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto a ela. Essa opção remove todas as informações referentes a uma etapa do sistema e, consequentemente, a desvincula de uma meta.
            Se uma etapa possuir itens e despesas (isso é, se existe valor empenhado) ela não poderá ser removida do sistema.

          </div>
          <div style="padding: 20px" id="participante_etapa">

            <h2>Participante de etapa</h2>
            A página de participantes de etapa é dedicada para o agrupamento de todos os participantes vinculados a etapas de convênios. Ela apresenta toda etapa e participante vinculados no sistema.
            A lista apresenta um total de 10 participantes de etapa por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de participantes apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de participantes na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um participante de etapa no sistema. Insira o título da etapa ou o nome do participante com os quais você acredita que um vínculo possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de um participante a uma etapa, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para cadastrar um participante de etapa, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Participante de etapa. Você será redirecionado para a página de cadastro.
            Para vinculação de uma pessoa a uma etapa é necessário que ela esteja vinculada como participante ao mesmo convênio da etapa. Uma vez que isso aconteça, um vínculo poderá ser criado para que o participante de convênio possa ser participante de uma etapa.
            Escolha a etapa e o participante através dos campos ‘Etapa Plano de trabalho’ e ‘Participantes’, respectivamente. Os campos não podem ser manipulados de forma manual e ambos devem ser preenchidos a partir de listas apresentadas. É possível adicionar novos participantes e etapas para vinculação no cadastro de ‘Participante’ e ‘Etapa do plano de trabalho’ (consulte o manual das páginas para detalhes).
            Após preencher os dois campos obrigatórios, clique no botão [botão] para vincular um participante de convênio a uma etapa.
            Caso tenha preenchido algum campo de forma incorreta e o participante de etapa tenha sido cadastrado, altere-o (consulte a próxima seção para detalhes quanto a modificação desse vínculo). Caso algum erro tenha sido gerado na tentativa de vinculação de participante a etapa de um convênio, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um vínculo de participante de etapa, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao vínculo que deseja modificar. Nessa página você poderá alterar ambos participante e etapa.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração de participante de etapa, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Exclua um participante de uma etapa clicando no botão <span class="glyphicon glyphicon-trash"></span> que aparece junto ao vínculo. Essa opção remove o participante da etapa. As informações de ambos participante e etapa permanecem no sistema.

          </div>
          <div style="padding: 20px" id="item_etapa">

            <h2>Item de etapa</h2>
            A página de itens de etapa é dedicada para o agrupamento de todas os itens cadastrados no sistema. Ela apresenta a identificação do item e seu valor total em uma despesa de etapa. Para visualizar toda a informação referente a um item de etapa, basta clicar sobre qualquer um dos campos anteriormente mencionados desse. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 itens por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de itens apresentados por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de itens na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar um item em uma etapa. Insira a identificação do item ou da etapa com os quais você acredita que ele possa ter sido cadastrado e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de itens no sistema, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para inserir um novo item no sistema, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Item de etapa. Você será redirecionado para a página de cadastro.
            É necessário que um item esteja vinculado a uma etapa. Realiza essa vinculação através do campo ‘Etapa Plano de Trabalho’, preenchendo-o a partir da lista de etapas cadastradas apresentada. É possível adicionar novas etapas para vinculação no cadastro de ‘Etapa do plano de trabalho’ (consulte o manual das páginas para detalhes). Esse campo não pode ser alterado após cadastro de item.
            Os campos ‘Despesa’ e ‘Nome da Despesa’ são utilizados para referenciar a categoria das despesas de um item. Escolha a que melhor representa os gastos gerados para preenchê-los. Por serem complementares, é necessário que apenas um seja preenchido. Uma vez que isso aconteça, o outro será automaticamente escolhido. A inserção de novos registros nas listas apresentadas não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI. Ambos os campos podem ser alterado após cadastro.
            Preencha o campo ‘País’ e ‘Moeda’ com o país onde o item foi adquirido e a moeda utilizada na compra, respectivamente. Os campos não podem ser manipulados de forma manual e a inserção de novos registros nas listas apresentadas não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI. Nenhum dos campos poderá ser alterado após cadastro.
            O campo ‘Data Aplicação’ exige a data na qual um item foi adquirido. Utilize a formatação recomendada pelo campo (dd/mm/aaaa) e respeite o limite imposto pela etapa ao qual o item está vinculado. Esse campo não é alterável.
            Utilize os campos ‘Valor unitário Item’ e ‘Quantidade Item’ para informar o valor de uma unidade do item adquirido e a quantidade de itens adquiridos na etapa, respectivamente. O campo ‘Valor Total Item’ será preenchido automaticamente após preenchimento desses campos, multiplicando-os entre si. O resultado deve respeitar o limite imposto pelo valor empenhado para a etapa a qual o item está vinculado. Nenhum dos campos poderá ser alterado posteriormente.
            O campo ‘Descrição Item’ é reservado para a descrição do item adquirido. Altere-o quando necessário.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular um item a uma etapa.
            Caso tenha preenchido algum campo de forma incorreta e o item tenha sido cadastrado, altere-o (consulte a próxima seção para detalhes quanto a modificação de itens). Caso algum erro tenha sido gerado na vinculação de um item a uma etapa, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            Para alterar um item, clique no ícone <span class="glyphicon glyphicon-pencil"></span> que aparece junto ao item que deseja modificar. Nessa página você poderá alterar a categoria da despesa e a descrição do item. Os outros campos são protegidos e não podem ser modificados.
            Clique no botão [botão] para salvar alterações realizadas. Toda alteração que não for salva através desse botão será perdida. Caso algum erro tenha sido gerado na tentativa de alteração de um item, as alterações não serão efetivadas e recomenda-se a leitura do erro apresentado para a validação dessas.

            <h4>Exclusão</h4>
            Após inserção de um item a uma etapa, esse não pode ser removido. Caso essa ação seja necessária, contate o NTI.

          </div>
          <div style="padding: 20px" id="diaria">

            <h2>Diárias</h2>
            A página de diárias é dedicada para o agrupamento de todas diárias vinculadas a um prévio empenho. Ela apresenta a origem, o destino e a data de saída de uma diária de uma requisição de prévio empenho. Para visualizar toda a informação referente a uma diária, basta clicar sobre qualquer um dos campos anteriormente mencionados dessa. Você será redirecionado para uma página que apresentará todas as informações disponíveis.
            A lista apresenta um total de 10 diárias por página. Utilize a paginação situada no canto inferior direito da tela para navegar pelas páginas disponíveis. Você pode alterar a quantidade de diárias apresentadas por página no canto superior esquerdo da tela. Isso fará com que menos páginas sejam apresentadas e aumentará a quantidade de diárias na página atual pela nova quantidade escolhida.
            Utilize o campo de pesquisa situado no canto superior direito da tela para encontrar uma diária cadastrada no sistema. Insira o número do prévio empenho ou cidade com os quais você acredita que uma diária possa ter sido cadastrada e clique a tecla ‘Enter’ de seu teclado para obter uma resposta.
            Para a inserção, alteração ou exclusão de diárias a um prévio empenho, consulte as seções abaixo.

            <h4>Cadastro</h4>
            Para vincular uma nova diária a um prévio empenho, clique em um dos botões [botão] que aparecem nos cantos superior e inferior da página de Diárias. Você será redirecionado para a página de cadastro.
            Recomenda-se redobrada atenção no preenchimento dos campos de inserção de uma diária. Nenhum dos campos preenchidos poderá ser alterados após um cadastro.
            Utilize o campo […] para vincular um prévio empenho a diária. O campo não pode ser manipulado de forma manual e seu preenchimento deve ser feito através da lista de prévios empenhos apresentada. É possível adicionar novos prévios empenhos para vinculação no cadastro de ‘Prévio Empenho’ (consulte o manual das páginas para detalhes).
            Preencha o campo ‘Centro de Custo’ com a opção adequada para a diária a partir da lista apresentada. A inserção de novos registros nessa lista não é suportada. Caso seja necessária a inserção de novos registros a esse campo, contate o NTI.
            Os campos ‘Data da Saída’ e ‘Data do Retorno’ se referem a duração da viagem na qual a diária é utilizada. Preencha o primeiro campo com a data de partida e o segundo campo com a data de retorno, respectivamente. Utilize a formatação recomendada nos campos (dd/mm/aaaa) e respeite o limite imposto pelo prévio empenho ao qual a diária está vinculada.
            Os campos ‘Cidade de Origem’, ‘Cidade de Destino’, ‘Estado de Origem’ e ‘Estado de Destino’ exigem as cidades e estados envolvidos na viagem na qual a diária é utilizada. Preencha os campos a partir das listas apresentadas. A inserção de novos registros nessas listas não é suportada. Caso seja necessária a inserção de novos registros a esses campos, contate o NTI.
            O campo ‘Transporte’ apresenta uma lista com meios de transporte frequentemente utilizados em viagens. Escolha o que melhor representa a viagem na qual a diária será utilizada. A inserção de novos registros na lista apresentada a esse campo não é suportada. Caso seja necessária a inserção de novos registros, contate o NTI.
            Os campos ‘Quantidade de Auxílios Financeiros’ e ‘Valor do Auxílio Financeiro’ se referem ao auxílio financeiro da diária e requerem a quantidade de auxílios financeiros vinculados a ela e o valor unitário desse. O valor total gerado por esses campos junto aos gastos dos outros deve respeitar o limite imposto pelo prévio empenho ao qual a diária está vinculada. O campo ‘Percentual de Auxílio’ será automaticamente preenchido a partir deles.
            Preencha os campos ‘Quantidade de Alimentações’ e ‘Valor da Alimentação Diária’ com o número de alimentações dependentes na diária e o valor unitário delas. O valor total gerado por esses campos junto aos gastos dos outros deve respeitar o limite imposto pelo prévio empenho ao qual a diária está vinculada.
            De forma semelhante, preencha os campos ‘Quantidade de Hospedagens’ e ‘Valor da Hospedagem Diária’ com o número de hospedagens dependentes na diária e o valor unitário delas. O valor total gerado por eles junto aos gastos dos outros também deve respeitar o limite imposto pelo prévio empenho ao qual a diária está vinculada.
            O campo ‘Valor de Desligamento’ se refere […].
            Utilize os campos ‘Data da Conversão da Moeda’ e ‘Valor da Conversão da Moeda’ para expressar, respectivamente, a data em que a diária foi utilizada e o valor da conversão de moeda nesse período. Utilize a formatação recomendada no primeiro campo (dd/mm/aaaa) e respeite o limite imposto pelo prévio empenho ao qual a diária está vinculada.
            Após preencher os campos obrigatórios, clique no botão [botão] para vincular uma diária a um prévio empenho.
            Caso tenha preenchido algum campo de forma incorreta e a diária tenha sido cadastrada, contate o NTI. Caso algum erro tenha sido gerado na vinculação de uma diária a um prévio empenho, o cadastro não será efetivado e recomenda-se a leitura do erro apresentado para a validação desse.

            <h4>Alteração</h4>
            A alteração de uma diária não é permitida após a vinculação com um prévio empenho. Todos os campos são protegidos. Caso necessário, contate o NTI para modificação do registro.

            <h4>Exclusão</h4>
            Após inserção de uma diária a um prévio empenho, essa não pode ser removido. Caso essa ação seja necessária, contate o NTI.

          </div>
        </div>


        <div class="col-md-2">
          <ul class="nav nav-pills nav-stacked">
            <li role="presentation" >
              <a class="btn btn-warning" href="<?php echo url('principal'); ?>">Voltar</a>
            </li>
       </ul>
     </div>

@endsection
