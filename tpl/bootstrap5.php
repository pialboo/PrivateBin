<?php declare(strict_types=1);
use PrivateBin\I18n;
?><!DOCTYPE html>
<html lang="<?php echo I18n::getLanguage(); ?>"<?php echo I18n::isRtl() ? ' dir="rtl"' : ''; ?> class="h-100">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Security-Policy" content="<?php echo I18n::encode($CSPHEADER); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex" />
		<meta name="google" content="notranslate">
		<title><?php echo I18n::_($NAME); ?></title>
		<link type="text/css" rel="stylesheet" href="css/bootstrap5/bootstrap<?php echo I18n::isRtl() ? '.rtl' : ''; ?>-5.3.8.css" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap5/privatebin.css?<?php echo rawurlencode($VERSION); ?>" />
<?php
if ($SYNTAXHIGHLIGHTING) :
?>
		<link type="text/css" rel="stylesheet" href="css/prettify/prettify.css?<?php echo rawurlencode($VERSION); ?>" />
<?php
    if (!empty($SYNTAXHIGHLIGHTINGTHEME)) :
?>
		<link type="text/css" rel="stylesheet" href="css/prettify/<?php echo rawurlencode($SYNTAXHIGHLIGHTINGTHEME); ?>.css?<?php echo rawurlencode($VERSION); ?>" />
<?php
    endif;
endif;
?>
		<noscript><link type="text/css" rel="stylesheet" href="css/noscript.css" /></noscript>
		<?php $this->_linkTag('js/zlib-1.3.2.js'); ?>
		<?php $this->_scriptTag('js/jquery-3.7.1.js', 'defer'); ?>
<?php
if ($QRCODE) :
?>
		<?php $this->_scriptTag('js/kjua-0.10.0.js', 'defer'); ?>
<?php
endif;
?>
		<?php $this->_scriptTag('js/zlib.js', 'defer'); ?>
		<?php $this->_scriptTag('js/base-x-5.0.1.js', 'defer'); ?>
		<?php $this->_scriptTag('js/bootstrap-5.3.8.js', 'defer'); ?>
		<?php $this->_scriptTag('js/dark-mode-switch.js', 'defer'); ?>
<?php
if ($SYNTAXHIGHLIGHTING) :
?>
		<?php $this->_scriptTag('js/prettify.js', 'defer'); ?>
<?php
endif;
if ($MARKDOWN) :
?>
		<?php $this->_scriptTag('js/showdown-2.1.0.js', 'defer'); ?>
<?php
endif;
?>
		<?php $this->_scriptTag('js/purify-3.4.12.js', 'defer'); ?>
		<?php $this->_scriptTag('js/legacy.js', 'defer'); ?>
		<?php $this->_scriptTag('js/privatebin.js', 'defer'); ?>
		<!-- icon -->
		<link rel="apple-touch-icon" href="<?php echo I18n::encode($BASEPATH); ?>img/apple-touch-icon.png" sizes="180x180" />
		<link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16" />
		<link rel="manifest" href="manifest.json?<?php echo rawurlencode($VERSION); ?>" />
		<link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#ffcc00" />
		<link rel="shortcut icon" href="img/favicon.ico">
		<meta name="msapplication-config" content="browserconfig.xml">
		<meta name="theme-color" content="#ffe57e" />
		<!-- Twitter/social media cards -->
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo I18n::_('Encrypted note on %s', I18n::_($NAME)) ?>" />
		<meta name="twitter:description" content="<?php echo I18n::_('Visit this link to see the note. Giving the URL to anyone allows them to access the note, too.') ?>" />
		<meta name="twitter:image" content="<?php echo I18n::encode($BASEPATH); ?>img/apple-touch-icon.png" />
		<meta property="og:title" content="<?php echo I18n::_($NAME); ?>" />
		<meta property="og:site_name" content="<?php echo I18n::_($NAME); ?>" />
		<meta property="og:description" content="<?php echo I18n::_('Visit this link to see the note. Giving the URL to anyone allows them to access the note, too.') ?>" />
		<meta property="og:image" content="<?php echo I18n::encode($BASEPATH); ?>img/apple-touch-icon.png" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image:width" content="180" />
		<meta property="og:image:height" content="180" />
	</head>
	<body role="document" data-compression="<?php echo rawurlencode($COMPRESSION); ?>" class="d-flex flex-column h-100">
		<div id="passwordmodal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form id="passwordform" role="form">
							<div class="mb-3">
								<label for="passworddecrypt"><svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#eye" /></svg> <?php echo I18n::_('Please enter the password for this document:') ?></label>
								<div class="input-group">
									<input id="passworddecrypt" type="password" class="form-control input-password" placeholder="<?php echo I18n::_('Enter password') ?>" required="required" />
									<button class="btn btn-outline-secondary toggle-password" type="button" title="<?php echo I18n::_('Show password'); ?>" aria-label="<?php echo I18n::_('Show password'); ?>">
										<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#eye" /></svg>
									</button>
								</div>
							</div>
							<button type="submit" class="btn btn-success btn-block"><svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#power" /></svg> <?php echo I18n::_('Decrypt') ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="loadconfirmmodal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo I18n::_('This secret message can only be displayed once. Would you like to see it now?') ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo I18n::_('Close') ?>"></button>
					</div>
					<div class="modal-body text-center">
						<button id="loadconfirm-open-now" type="button" class="btn btn-success" data-bs-dismiss="modal"><svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#cloud-download" /></svg> <?php echo I18n::_('Yes, see it') ?></button>
					</div>
				</div>
			</div>
		</div>
<?php
if ($QRCODE) :
?>
		<div id="qrcodemodal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo I18n::_('QR code') ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo I18n::_('Close') ?>"></button>
					</div>
					<div class="modal-body">
						<div class="mx-auto" id="qrcode-display"></div>
					</div>
				</div>
			</div>
		</div>
<?php
endif;
if ($EMAIL) :
?>
		<div id="emailconfirmmodal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo I18n::_('Recipient may become aware of your timezone, convert time to UTC?') ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo I18n::_('Close') ?>"></button>
					</div>
					<div class="modal-body row">
						<div class="col-xs-12 col-md-6">
							<button id="emailconfirm-timezone-current" type="button" class="btn btn-danger"><svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#clock" /></svg> <?php echo I18n::_('Use Current Timezone') ?></button>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<button id="emailconfirm-timezone-utc" type="button" class="btn btn-success"><svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#globe" /></svg> <?php echo I18n::_('Convert To UTC') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
endif;
?>
		<nav class="navbar navbar-expand bg-body-tertiary mb-2 py-2 px-3 rounded shadow-sm">
			<div class="container-fluid flex-column align-items-stretch gap-2">
				<!-- Row 1: Logo + Create Button + View Actions + Password + Attach + (Right: Dark Mode & Language) -->
				<div class="d-flex align-items-center justify-content-between w-100 flex-nowrap gap-2 overflow-x-auto">
					<!-- Left side: Brand Logo + Create Button + View Actions + Password + Attach -->
					<div class="d-flex align-items-center gap-2 text-nowrap flex-nowrap">
						<a class="reloadlink navbar-brand me-2 py-0" href="">
							<img alt="<?php echo I18n::_($NAME); ?>" src="img/icon.svg" height="30" />
						</a>
						<button id="sendbutton" type="button" tabindex="2" class="hidden btn btn-primary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#cloud-upload" /></svg> <?php echo I18n::_('Create'), PHP_EOL; ?>
						</button>
						<button id="retrybutton" type="button" class="reloadlink hidden btn btn-primary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#repeat" /></svg> <?php echo I18n::_('Retry'), PHP_EOL; ?>
						</button>
						<button id="newbutton" type="button" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#file-earmark" /></svg> <?php echo I18n::_('New'), PHP_EOL; ?>
						</button>
						<button id="clonebutton" type="button" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#copy" /></svg> <?php echo I18n::_('Clone'), PHP_EOL; ?>
						</button>
						<button id="rawtextbutton" type="button" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#filetype-txt" /></svg> <?php echo I18n::_('Raw text'), PHP_EOL; ?>
						</button>
						<button id="downloadtextbutton" type="button" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#download" /></svg> <?php echo I18n::_('Save document'), PHP_EOL; ?>
						</button>
<?php if ($EMAIL) : ?>
						<button id="emaillink" type="button" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#envelope" /></svg> <?php echo I18n::_('Email'), PHP_EOL; ?>
						</button>
<?php endif; ?>
<?php if ($QRCODE) : ?>
						<button id="qrcodelink" type="button" data-bs-toggle="modal" data-bs-target="#qrcodemodal" class="hidden btn btn-secondary btn-sm d-flex align-items-center gap-1">
							<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#qr-code" /></svg> <?php echo I18n::_('QR code'), PHP_EOL; ?>
						</button>
<?php endif; ?>

						<!-- Password -->
<?php if ($PASSWORD) : ?>
						<div id="password" class="navbar-form hidden">
							<div class="input-group input-group-sm">
								<input type="password" id="passwordinput" placeholder="<?php echo I18n::_('Password'); ?>" aria-label="<?php echo I18n::_('Password (recommended)'); ?>" class="form-control input-password" size="14" />
								<button class="btn btn-outline-secondary btn-sm toggle-password" type="button" title="<?php echo I18n::_('Show password'); ?>" aria-label="<?php echo I18n::_('Show password'); ?>">
									<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#eye" /></svg>
								</button>
							</div>
						</div>
<?php endif; ?>

						<!-- Attach File -->
						<div id="attach" class="d-inline-flex align-items-center gap-1 hidden text-nowrap">
							<button type="button" id="attachbtn" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
								<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#paperclip" /></svg>
								<span id="attachtext"><?php echo I18n::_('Attach a file'); ?></span>
							</button>
							<input type="file" id="file" name="file" class="d-none" multiple />
							<button type="button" id="fileremovebutton" class="btn btn-outline-danger btn-sm hidden d-flex align-items-center gap-1" title="<?php echo I18n::_('Remove attachment'); ?>">
								<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#trash" /></svg>
							</button>
							<div id="filewrap" class="d-none"></div>
							<div id="dragAndDropFileName" class="d-none"></div>
							<div id="customattachment" class="d-none"></div>
						</div>
					</div>

					<!-- Right side: Dark Mode + Language -->
					<div class="d-flex align-items-center gap-2 text-nowrap flex-shrink-0 ms-auto">
						<div class="form-check form-switch text-nowrap my-0">
							<input id="bd-theme" type="checkbox" class="form-check-input" />
							<label for="bd-theme" class="form-check-label small ms-1 me-1"><?php echo I18n::_('Dark Mode'); ?></label>
						</div>
<?php if (!empty($LANGUAGESELECTION)) : ?>
						<div id="language" class="dropdown">
							<a href="#" class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown" aria-expanded="false">
								<svg width="14" height="14" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#flag" /></svg> <?php echo $LANGUAGES[$LANGUAGESELECTION][0], PHP_EOL; ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-end" role="menu">
<?php foreach ($LANGUAGES as $key => $value) : ?>
								<li>
									<a href="#" class="dropdown-item" data-lang="<?php echo $key; ?>">
										<?php echo $value[0]; ?> (<?php echo $value[1]; ?>)
									</a>
								</li>
<?php endforeach; ?>
							</ul>
						</div>
<?php endif; ?>
					</div>
				</div>

				<!-- Row 2: Format + Expires + Custom ID + Burn after reading + Open discussion -->
				<div id="navbar-settings-row" class="d-flex align-items-center gap-3 pt-1 border-top w-100 flex-nowrap overflow-x-auto">
					<!-- Format -->
					<div id="formatter" class="d-flex align-items-center hidden text-nowrap">
						<label for="pasteFormatter" class="form-label my-auto me-1 small flex-shrink-0"><?php echo I18n::_('Format'); ?>:</label>
						<select id="pasteFormatter" name="pasteFormatter" class="form-select form-select-sm">
<?php foreach ($FORMATTER as $key => $value) : ?>
							<option value="<?php echo $key; ?>"<?php if ($key === $FORMATTERDEFAULT) : ?> selected="selected"<?php endif; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
						</select>
					</div>

					<!-- Expires -->
					<div id="expiration" class="d-flex align-items-center hidden text-nowrap">
						<label for="pasteExpiration" class="form-label my-auto me-1 small flex-shrink-0"><?php echo I18n::_('Expires'); ?>:</label>
						<select id="pasteExpiration" name="pasteExpiration" class="form-select form-select-sm">
<?php foreach ($EXPIRE as $key => $value) : ?>
							<option value="<?php echo $key; ?>"<?php if ($key === $EXPIREDEFAULT) : ?> selected="selected"<?php endif; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
						</select>
					</div>

					<!-- Custom ID Input -->
					<div id="customid" class="navbar-form hidden">
						<div class="input-group input-group-sm">
							<span class="input-group-text py-0 px-2 small"><?php echo I18n::_('Custom ID'); ?></span>
							<input type="text" id="customidinput" placeholder="<?php echo I18n::_('5 digits'); ?>" aria-label="<?php echo I18n::_('Custom ID'); ?>" class="form-control" size="8" maxlength="5" pattern="[0-9]{5}" inputmode="numeric" />
						</div>
					</div>

					<!-- Options: Burn after reading -->
					<div id="burnafterreadingoption" class="form-check hidden text-nowrap my-0">
						<input class="form-check-input" type="checkbox" id="burnafterreading" name="burnafterreading"<?php if ($BURNAFTERREADINGSELECTED) : ?> checked="checked"<?php endif; ?> />
						<label class="form-check-label small" for="burnafterreading">
							<?php echo I18n::_('Burn after reading'), PHP_EOL; ?>
						</label>
					</div>

					<!-- Options: Open discussion -->
<?php if ($DISCUSSION) : ?>
					<div id="opendiscussionoption" class="form-check hidden text-nowrap my-0">
						<input class="form-check-input" type="checkbox" id="opendiscussion" name="opendiscussion"<?php if ($OPENDISCUSSION) : ?> checked="checked"<?php endif; ?> />
						<label class="form-check-label small" for="opendiscussion">
							<?php echo I18n::_('Open discussion'), PHP_EOL; ?>
						</label>
					</div>
<?php endif; ?>
				</div>
			</div>
		</nav>
		<main class="d-flex flex-column flex-grow-1 min-height-0 overflow-hidden">
			<section class="container-fluid flex-shrink-0 mt-1">
<?php
if (!empty($NOTICE)) :
?>
				<div role="alert" class="alert alert-info py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#info-circle" /></svg>
					<?php echo I18n::encode($NOTICE), PHP_EOL; ?>
				</div>
<?php
endif;
?>
				<div id="remainingtime" role="alert" class="hidden alert alert-info py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#fire" /></svg>
				</div>
				<div id="attachment" class="hidden"></div>
				<div id="status" role="alert" class="d-flex align-items-center gap-2 alert alert-<?php echo $ISDELETED ? 'success' : 'info'; echo empty($STATUS) ? ' hidden' : '' ?> py-2 mb-2">
					<div>
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#info-circle" /></svg>
						<?php echo I18n::encode($STATUS), PHP_EOL; ?>
					</div>
<?php
if ($ISDELETED) :
?>
					<button type="button" class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center gap-1 ms-auto" id="new-from-alert">
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#repeat" /></svg>
						<?php echo I18n::_('Start over'), PHP_EOL; ?>
					</button>
<?php
endif;
?>
				</div>
				<div id="errormessage" role="alert" class="<?php echo empty($ERROR) ? 'hidden' : '' ?> alert alert-danger py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-triangle" /></svg>
					<?php echo I18n::encode($ERROR), PHP_EOL; ?>
				</div>
				<noscript>
					<div id="noscript" role="alert" class="alert alert-warning py-2 mb-2">
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-circle" /></svg>
						<?php echo I18n::_('JavaScript is required for %s to work. Sorry for the inconvenience.', I18n::_($NAME)), PHP_EOL; ?>
					</div>
				</noscript>
				<div id="oldnotice" role="alert" class="hidden alert alert-danger py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-triangle" /></svg>
					<?php echo I18n::_('%s requires a modern browser to work.', I18n::_($NAME)), PHP_EOL; ?>
					<a href="https://www.mozilla.org/firefox/">Firefox</a>,
					<a href="https://www.opera.com/">Opera</a>,
					<a href="https://www.google.com/chrome">Chrome</a>…<br />
					<span class="small"><?php echo I18n::_('For more information <a href="%s">see this FAQ entry</a>.', 'https://github.com/PrivateBin/PrivateBin/wiki/FAQ#why-does-it-show-me-the-error-privatebin-requires-a-modern-browser-to-work'); ?></span>
				</div>
<?php
if ($HTTPWARNING) :
?>
				<div id="httpnotice" role="alert" class="hidden alert alert-danger py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-triangle" /></svg>
					<?php echo I18n::_('This website is using an insecure connection! Please only use it for testing.'); ?><br />
					<span class="small"><?php echo I18n::_('For more information <a href="%s">see this FAQ entry</a>.', 'https://github.com/PrivateBin/PrivateBin/wiki/FAQ#why-does-it-show-me-an-error-about-an-insecure-connection'); ?></span>
				</div>
				<div id="insecurecontextnotice" role="alert" class="hidden alert alert-danger py-2 mb-2">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-triangle" /></svg>
					<?php echo I18n::_('Your browser may require an HTTPS connection to support the WebCrypto API. Try <a href="%s">switching to HTTPS</a>.', $HTTPSLINK), PHP_EOL; ?>
				</div>
<?php
endif;
?>
				<div id="pastesuccess" class="hidden mb-2">
					<div class="nav justify-content-between mb-2">
						<button id="copyLink" type="button" class="btn btn-secondary d-flex justify-content-center align-items-center gap-1">
							<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#copy" /></svg> <?php echo I18n::_('Copy link') ?>
						</button>
						<a href="#" id="deletelink" class="btn btn-secondary d-flex justify-content-center align-items-center gap-1">
							<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#trash" /></svg>
							<span></span>
						</a>
					</div>
					<div role="alert" class="alert alert-success">
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#check" /></svg>
						<div id="pastelink"></div>
					</div>
<?php
if (!empty($URLSHORTENER)) :
?>
					<p>
						<button id="shortenbutton" data-shortener="<?php echo I18n::encode($URLSHORTENER); ?>"
								<?php if ($SHORTENBYDEFAULT) : ?>
								data-autoshorten="true"
								<?php endif; ?>
								type="button" class="btn btn-primary btn-block d-flex justify-content-center align-items-center gap-1"
						>
							<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#send" /></svg> <?php echo I18n::_('Shorten URL'), PHP_EOL; ?>
						</button>
					</p>
					<div role="alert" class="alert alert-danger">
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-circle" /></svg>
						<?php if ($SHORTENBYDEFAULT) : ?>
							<?php echo I18n::_('URL shortener is enabled by default.'), PHP_EOL; ?>
						<?php endif; ?>
						<?php echo I18n::_('URL shortener may expose your decrypt key in URL.'), PHP_EOL; ?>
					</div>
<?php
endif;
?>
				</div>
				<ul id="editorTabs" class="nav nav-tabs hidden mb-1">
					<li role="presentation" class="nav-item me-1"><a class="nav-link active py-1 px-2" role="tab" id="messageedit" href="#"><?php echo I18n::_('Editor'); ?></a></li>
					<li role="presentation" class="nav-item me-1"><a class="nav-link py-1 px-2" role="tab" id="messagepreview" href="#"><?php echo I18n::_('Preview'); ?></a></li>
				</ul>
			</section>
			<section class="container-fluid section-editor flex-grow-1 d-flex flex-column min-height-0 overflow-hidden">
				<article class="flex-grow-1 d-flex flex-column min-height-0 overflow-hidden">
					<div id="placeholder" class="col-md-12 hidden"><?php echo I18n::_('+++ no document text +++'); ?></div>
					<div id="attachmentPreview" class="col-md-12 text-center hidden"></div>
					<h6 id="copyShortcutHint" class="col-md-12 nav justify-content-between align-items-center mb-1 hidden">
						<small id="copyShortcutHintText" class="d-none d-md-inline">
							<?php
								echo I18n::_("To copy document press on the copy button or use the clipboard shortcut <kbd>%s</kbd>+<kbd>c</kbd>", I18n::getCopyHotkey())
							?>
						</small>
						<button type="button" id="copyShortcutHintBtn" class="btn btn-secondary btn-sm ms-auto"><?php echo I18n::_('Copy'); ?></button>
					</h6>
					<div id="prettymessage" class="card col-md-12 flex-grow-1 min-height-0 overflow-auto hidden">
						<pre id="prettyprint" class="card-body col-md-12 prettyprint linenums:1"></pre>
					</div>
					<div id="plaintext" class="col-md-12 flex-grow-1 min-height-0 overflow-auto hidden"></div>
					<textarea id="message" name="message" cols="80" rows="10" aria-label="<?php echo I18n::_('Document text'); ?>" tabindex="1" class="form-control flex-grow-1 min-height-0 hidden"></textarea>
					<div class="d-flex align-items-center justify-content-between my-1 flex-shrink-0">
						<div class="form-check form-switch my-0">
							<input id="messagetab" type="checkbox" tabindex="3" class="form-check-input" checked="checked" />
							<label for="messagetab" class="form-check-label small">
								<?php echo I18n::_('Tabulator key serves as character (Hit <kbd>Ctrl</kbd>+<kbd>m</kbd> or <kbd>Esc</kbd> to toggle)'), PHP_EOL; ?>
							</label>
						</div>
					</div>
				</article>
			</section>
			<section class="container-fluid flex-shrink-0">
				<div id="discussion" class="hidden">
					<h4><?php echo I18n::_('Discussion'); ?></h4>
					<div id="commentcontainer"></div>
				</div>
			</section>
			<section class="container-fluid flex-shrink-0">
				<div id="noscript" role="alert" class="alert alert-info noscript-hide py-1 mb-1">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#exclamation-circle" /></svg>
					<?php echo I18n::_('Loading…'); ?><br />
					<span class="small"><?php echo I18n::_('In case this message never disappears please have a look at <a href="%s">this FAQ for information to troubleshoot</a>.', 'https://github.com/PrivateBin/PrivateBin/wiki/FAQ#why-does-the-loading-message-not-go-away'); ?></span>
				</div>
			</section>
		</main>
		<footer class="container-fluid flex-shrink-0 text-center py-1 mt-auto">
			<small class="text-body-secondary"><?php echo I18n::_($NAME); ?> v<?php echo $VERSION; ?></small>
		</footer>
		<div id="serverdata" class="hidden" aria-hidden="true">
			<div id="templates">
				<article id="commenttemplate" class="comment px-2 pb-3">
					<div class="commentmeta">
						<span class="nickname">name</span>
						<span class="commentdate">0000-00-00</span>
					</div>
					<div class="commentdata">c</div>
					<button class="btn btn-secondary btn-sm"><?php echo I18n::_('Reply'); ?></button>
				</article>
				<p id="commenttailtemplate" class="comment px-2 pb-3">
					<button class="btn btn-secondary btn-sm"><?php echo I18n::_('Add comment'); ?></button>
				</p>
				<div id="replytemplate" class="reply hidden">
					<input type="text" id="nickname" class="form-control my-2" title="<?php echo I18n::_('Optional nickname…'); ?>" placeholder="<?php echo I18n::_('Optional nickname…'); ?>" />
					<textarea id="replymessage" class="replymessage form-control" cols="80" rows="7"></textarea><br />
					<div id="replystatus" role="alert" class="statusmessage hidden alert">
						<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#info-circle" /></svg>
					</div>
					<button id="replybutton" class="btn btn-secondary btn-sm"><?php echo I18n::_('Post comment'); ?></button>
				</div>
				<div id="attachmenttemplate" role="alert" class="hidden alert alert-info">
					<svg width="16" height="16" fill="currentColor" aria-hidden="true"><use href="img/bootstrap-icons.svg#download" /></svg>
					<a class="alert-link"><?php echo I18n::_('Download attachment'); ?><span></span></a>
				</div>
			</div>
		</div>
<?php
if ($FILEUPLOAD) :
?>
		<div id="dropzone" class="hidden" tabindex="-1" aria-hidden="true"></div>
<?php
endif;
?>
	</body>
</html>
