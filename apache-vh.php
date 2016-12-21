<?php
	error_reporting(0);

	$sistema = PHP_OS;
	$id      = posix_getuid();

	function configurar($nomedoservidor,$dominio,$ssl) {
		if (file_exists("/etc/apache2") == true) {
			if (file_exists("/etc/apache2/sites-available/".$nomedoservidor.".conf")) {
				$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
  --> Existe outro servidor com o mesmo nome
";
				print($conteudo);
			} else {
				$status   = "";
				$etchosts = file_get_contents("/etc/hosts");
				$host     = "127.0.0.1	".$dominio;
				$config   = "<VirtualHost *:80>
	ServerAdmin webmaster@localhost
    ServerName ".$nomedoservidor."
    ServerAlias ".$dominio."
	DocumentRoot /var/www/".$nomedoservidor."/public_html

	ErrorLog /var/www/".$nomedoservidor."/error.log
	CustomLog /var/www/".$nomedoservidor."/access.log combined
</VirtualHost>
";

				if (file_put_contents("/etc/apache2/sites-available/".$nomedoservidor.".conf", $config)) {
					$status .= "  --> Arquivo \e[1m/etc/apache2/sites-available/".$nomedoservidor.".conf\e[0m criado\n";
				} else {
					$status .= "  --> Erro ao criar o arquivo \e[1m/etc/apache2/sites-available/".$nomedoservidor.".conf\e[0m\n";
				}

				if (file_put_contents("/etc/apache2/sites-enabled/".$nomedoservidor.".conf", $config)) {
					$status .= "  --> Arquivo \e[1m/etc/apache2/sites-enabled/".$nomedoservidor.".conf\e[0m criado\n";
				} else {
					$status .= "  --> Erro ao criar o arquivo \e[1m/etc/apache2/sites-enabled/".$nomedoservidor.".conf\e[0m\n";
				}

				if (mkdir("/var/www/".$nomedoservidor)) {
					$status .= "  --> Pasta \e[1m/var/www/".$nomedoservidor."\e[0m criada\n";
				} else {
					$status .= "  --> Erro ao criar a pasta \e[1m/var/www/".$nomedoservidor."\e[0m\n";
				}

				if (mkdir("/var/www/".$nomedoservidor."/public_html")) {
					$status .= "  --> Pasta \e[1m/var/www/".$nomedoservidor."/public_html\e[0m criada\n";
				} else {
					$status .= "  --> Erro ao criar a pasta \e[1m/var/www/".$nomedoservidor."/public_html\e[0m\n";
				}

				if (file_put_contents("/etc/hosts", $etchosts."\n".$host)) {
					$status .= "  --> Arquivo \e[1m/etc/hosts\e[0m atualizado\n";
				} else {
					$status .= "  --> Erro ao atualizar o arquivo \e[1m/etc/hosts\e[0m\n";
				}

				shell_exec("service apache2 restart");
				$status .= "  --> Servidor \e[1mApache\e[0m reiniciado\n";

				$index = "<center>O domínio ".$dominio." foi ativado<br><br>Apache VirtualHosts Config by João Artur (K3N1)</center>";
				if (file_put_contents("/var/www/".$nomedoservidor."/public_html/index.html", $index)) {
					$status .= "  --> Arquivo \e[1mindex.html\e[0m criado\n";
				} else {
					$status .= "  --> Erro ao criar o arquivo \e[1mindex.html\e[0m\n";
				}

				$status .= "  --> Configuração de certificado SSL em breve\n";

				$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Status:
".$status."
";
				print($conteudo);
			}
		} else {
			$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
  --> Diretório \e[1m/etc/apache2\e[0m não encontrado
";
			print($conteudo);
		}
	}
	if ($sistema == "Linux" && $id == 0) {
		system("clear");
		$argc = $argc - 1;
		switch ($argc) {
			case '3':
				$nomedoservidor = strtolower(str_replace(array(",",".",";","-"," "), "", $argv[1]));
				$dominio = (strpos($argv[2],'.')) ? strtolower(str_replace(array("http://","https://"), "", $argv[2])) : "no";
				$ssl = strtoupper($argv[3]);
				$ssl = ($ssl == "S" || $ssl == "N") ? $ssl : "no";
				if ($dominio == "no") {
					$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
  --> Domínio inválido
";
					print($conteudo);
				} else {
					if ($ssl == "no") {
						$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
  --> Para a configuração do SSL é aceito apenas S/N
";
						print($conteudo);
					} else {
						if ($ssl != "no" && $dominio != "no") {
							configurar($nomedoservidor,$dominio,$ssl);
						} else {
							$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
  --> Erro inesperado.
";
							print($conteudo);
						}
					}
				}
				break;
			default:
				$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Uso:
  --> php ".$argv[0]." NomeDoServidor Domínio SSL
Exemplo:
  --> php ".$argv[0]." kenihacking kenihacking.com s

NomeDoServidor: nome do servidor
Domínio: domínio do site
SSL: auto-configurar certificado SSL (S/N)
";
				print($conteudo);
				break;
		}
	} else {
		$erros = "";
		if ($sistema != "Linux") {
			$erros .= "  --> Sistema operacional deve ser Linux\n";
		}
		if ($id != 0) {
			$erros .= "  --> Script deve ser executado como Root";
		}
		$conteudo = "\e[31m\e[1m   _                 _         __   ___     _             _ _  _        _      
  /_\  _ __  __ _ __| |_  ___  \ \ / (_)_ _| |_ _  _ __ _| | || |___ __| |_ ___
 / _ \| '_ \/ _` / _| ' \/ -_)  \ V /| | '_|  _| || / _` | | __ / _ (_-<  _(_-<
/_/ \_\ .__/\__,_\__|_||_\___|   \_/ |_|_|  \__|\_,_\__,_|_|_||_\___/__/\__/__/
      |_|                                                                      
			  ___           __ _      
			 / __|___ _ _  / _(_)__ _ 
			| (__/ _ \ ' \|  _| / _` |
			 \___\___/_||_|_| |_\__, |
			                    |___/       By João Artur (K3N1)
\e[0m

Erro:
".$erros."
";
		print($conteudo);
	}
?>