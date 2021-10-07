# mirasz@icube.us
# magento 2.2 minimum downtime deployment

domain_name=$(hostname -f)
email="sysadmin@icube.us"

release_version=$(date +%Y%m%d%H%M%S)

site_dir=/home/mage2user/site
releases=/releases/
current=/current
shared=/shared
pub_dir=pub
log_dir=var/log
web_dir=$site_dir$releases$release_version
shr_dir=$site_dir$shared
merged_dir=pub/static/_cache/merged
weltpixel_dir=app/code/WeltPixel
update_dir=$web_dir/update

read_repo=""
read_branch=""

COMBI=`getopt -o h --long fix-permission,full,composer-install,no-setup-upgrade,setup-upgrade,composer-new-module,static-deploy-only,ca-cl,ca-fl,help -- "$@"` 
eval set -- "$COMBI"

while true; do
case "$1" in

	# --fix-permission
	--fix-permission) CASE_FIXPERM='Fix file & folder permission'; shift
	echo "$CASE_FIXPERM"

		cd $web_dir
		find $pub_dir/ -type f -print0 | xargs -0 chmod 664
		find $pub_dir/ -type d -print0 | xargs -0 chmod 775
		find $log_dir/ -type f -print0 | xargs -0 chmod 664
		find $log_dir/ -type d -print0 | xargs -0 chmod 775
		chown -h mage2user. $site_dir$current
		chown -R mage2user. $site_dir$current/
		;;

	# --full
	--full) CASE_FULL='Full deployment WITHOUT composer install'; shift
	echo "$CASE_FULL"

		# Identify repository & branch
		if [ -z "$read_repo" ]
		then
			read -p "Repository name (example: git@github.com:icubeus/swift.git): " read_repo
		fi
		if [ -z "$read_branch" ]
		then
			read -p "Branch to be deployed (example: master): " read_branch
		fi

		echo "Clone latest code"
		cd $site_dir$releases 
		git clone $read_repo $release_version
		cd $web_dir
		git checkout $read_branch

		cd $web_dir
		echo "Update Symlink: configuration"
		ln -s $shr_dir/config/env.php $site_dir/releases/$release_version/app/etc/env.php
		ln -s $shr_dir/config/config.php $site_dir/releases/$release_version/app/etc/config.php

		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/
		php bin/magento cache:flush
		php bin/magento setup:di:compile
		php bin/magento deploy:mode:set developer
		rm -rf generated/*
		rm -rf generated/*
		php bin/magento weltpixel:cleanup
		find $weltpixel_dir/FrontendOptions/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/FrontendOptions/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomFooter/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomFooter/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomHeader/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomHeader/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CategoryPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CategoryPage/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/ProductPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/ProductPage/view -type f -print0 | xargs -0 chmod 664
		php bin/magento weltpixel:less:generate
		php bin/magento setup:static-content:deploy -f
		php bin/magento weltpixel:css:generate --store=default
		php bin/magento maintenance:enable
		php bin/magento setup:upgrade --keep-generated
		php bin/magento deploy:mode:set production -s
		php bin/magento maintenance:disable
		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/ var/report/
		php bin/magento cache:flush
		php bin/magento cache:enable
		cd $update_dir && composer install && cd $web_dir

		echo "Update Symlink: media/catalog"
		mv $site_dir/releases/$release_version/$pub_dir/media/catalog $site_dir/releases/$release_version/$pub_dir/media/catalog.original
		ln -s $shr_dir/media/catalog/ $site_dir/releases/$release_version/$pub_dir/media/catalog

		echo "Update Symlink: media/wysiwyg"
		mv $site_dir/releases/$release_version/$pub_dir/media/wysiwyg $site_dir/releases/$release_version/$pub_dir/media/wysiwyg.original
		ln -s $shr_dir/media/wysiwyg/ $site_dir/releases/$release_version/$pub_dir/media/wysiwyg

		echo "Update Symlink: current"
		rm $site_dir/current
		ln -s $web_dir $site_dir/current
		;;

	# --composer-install
	--composer-install) CASE_CI='Full deployment WITH composer install'; shift
	echo "$CASE_CI"

		# Identify repository & branch
		if [ -z "$read_repo" ]
		then
			read -p "Repository name (example: git@github.com:icubeus/swift.git): " read_repo
		fi
		if [ -z "$read_branch" ]
		then
			read -p "Branch to be deployed (example: master): " read_branch
		fi

		echo "Clone latest code"
		cd $site_dir$releases 
		git clone $read_repo $release_version
		cd $web_dir
		git checkout $read_branch

		cd $web_dir
		echo "Update Symlink: configuration"
		ln -s $shr_dir/config/env.php $site_dir/releases/$release_version/app/etc/env.php
		ln -s $shr_dir/config/config.php $site_dir/releases/$release_version/app/etc/config.php

		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/
		php bin/magento cache:flush
		composer install
		php bin/magento setup:di:compile
		php bin/magento deploy:mode:set developer
		rm -rf generated/*
		rm -rf generated/*
		php bin/magento weltpixel:cleanup
		find $weltpixel_dir/FrontendOptions/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/FrontendOptions/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomFooter/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomFooter/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomHeader/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomHeader/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CategoryPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CategoryPage/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/ProductPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/ProductPage/view -type f -print0 | xargs -0 chmod 664
		php bin/magento weltpixel:less:generate
		php bin/magento setup:static-content:deploy -f
		php bin/magento weltpixel:css:generate --store=default
		php bin/magento maintenance:enable
		php bin/magento setup:upgrade --keep-generated
		php bin/magento deploy:mode:set production -s
		php bin/magento maintenance:disable
		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/ var/report/
		php bin/magento cache:flush
		php bin/magento cache:enable
		cd $update_dir && composer install && cd $web_dir

		echo "Update Symlink: media/catalog"
		mv $site_dir/releases/$release_version/$pub_dir/media/catalog $site_dir/releases/$release_version/$pub_dir/media/catalog.original
		ln -s $shr_dir/media/catalog/ $site_dir/releases/$release_version/$pub_dir/media/catalog

		echo "Update Symlink: media/wysiwyg"
		mv $site_dir/releases/$release_version/$pub_dir/media/wysiwyg $site_dir/releases/$release_version/$pub_dir/media/wysiwyg.original
		ln -s $shr_dir/media/wysiwyg/ $site_dir/releases/$release_version/$pub_dir/media/wysiwyg

		echo "Update Symlink: current"
		rm $site_dir/current
		ln -s $web_dir $site_dir/current
		;;

	# --no-setup-upgrade
	--no-setup-upgrade) CASE_NSU='Full deployment WITHOUT setup upgrade'; shift
	echo "$CASE_NSU"

		cd $site_dir$current
		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/
		php bin/magento cache:flush
		php bin/magento setup:di:compile
		php bin/magento deploy:mode:set developer
		rm -rf generated/*
		rm -rf generated/*
		php bin/magento weltpixel:cleanup
		find $weltpixel_dir/FrontendOptions/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/FrontendOptions/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomFooter/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomFooter/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomHeader/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomHeader/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CategoryPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CategoryPage/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/ProductPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/ProductPage/view -type f -print0 | xargs -0 chmod 664
		php bin/magento weltpixel:less:generate
		php bin/magento setup:static-content:deploy -f
		php bin/magento weltpixel:css:generate --store=default
		php bin/magento deploy:mode:set production -s
		rm -rf var/cache/ var/page_cache/ var/di/ var/generation/ var/tmp/ var/report/
		php bin/magento cache:flush
		php bin/magento cache:enable
		cd $update_dir && composer install && cd $web_dir
		;;

	# install new module: magento
	--setup-upgrade) CASE_SU='Magento setup:upgrade only -- install new module'; shift
	echo "$CASE_SU"

		cd $site_dir$current
		php bin/magento cache:flush
		php bin/magento maintenance:enable
		php bin/magento setup:upgrade --keep-generated
		php bin/magento maintenance:disable
		php bin/magento cache:flush
		php bin/magento cache:enable
		;;

	# install new module: composer
	--composer-new-module) CASE_CO='Composer install only -- install new module'; shift
	echo "$CASE_CO"

		cd $site_dir$current
		php bin/magento cache:flush
		composer install
		php bin/magento cache:flush
		php bin/magento cache:enable
		;;

	# --static-deploy-only
	--static-deploy-only) CASE_ST='Magento static content deploy only'; shift
	echo "$CASE_ST"

		cd $site_dir$current
		php bin/magento cache:flush
		php bin/magento deploy:mode:set developer
		php bin/magento weltpixel:cleanup
		find $weltpixel_dir/FrontendOptions/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/FrontendOptions/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomFooter/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomFooter/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CustomHeader/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CustomHeader/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/CategoryPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/CategoryPage/view -type f -print0 | xargs -0 chmod 664
		find $weltpixel_dir/ProductPage/view -type d -print0 | xargs -0 chmod 775
		find $weltpixel_dir/ProductPage/view -type f -print0 | xargs -0 chmod 664
		php bin/magento weltpixel:less:generate
		php bin/magento setup:static-content:deploy -f
		php bin/magento cache:flush
		php bin/magento cache:enable
		cd $update_dir && composer install && cd $web_dir
		;;

	# --ca-cl
	--ca-cl) CASE_CL='Magento cache:clean'; shift
	echo "$CASE_CL"

		cd $site_dir$current
		php bin/magento cache:clean
		php bin/magento cache:enable
		;;

	# --ca-fl
	--ca-fl) CASE_FL='Magento cache:flush'; shift
	echo "$CASE_FL"

		cd $site_dir$current
		php bin/magento cache:flush
		php bin/magento cache:enable
		;;

	# --help
	-h|--help) CASE_H='Help Page'; shift
	echo "$CASE_H"

		printf "\n"
		printf "Example usage:\n\n"
		printf "Deployment with all options enabled WITHOUT composer install:\n"
		printf "  bash deploy_prd.sh --full\n\n"
		printf "Deployment with all options enabled WITH composer install:\n"
		printf "  bash deploy_prd.sh --composer-install\n\n"
		printf "Deployment with fixing file & folder permission in pub/ & var/log/ directory:\n"
		printf "  bash deploy_prd.sh --full --fix-permission\t\t\t OR\n"
		printf "  bash deploy_prd.sh --composer-install --fix-permission\n\n"
		printf "Deployment with all options enabled WITHOUT composer install AND setup upgrade in current code version (no git clone):\n"
		printf "  bash deploy_sh.sh --no-setup-upgrade\n\n"
		printf "Install new module (magento) ONLY in current code version (no git clone, no deployment):\n"
		printf "  bash deploy_prd.sh --setup-upgrade\n\n"
		printf "Install new module (composer) ONLY in current code version (no git clone, no deployment):\n"
		printf "  bash deploy_prd.sh --composer-new-module\n\n"
		printf "Static content deploy ONLY in current code version (no git clone, no deployment):\n"
		printf "  bash deploy_prd.sh --static-deploy\n\n"
		printf "Clean cache ONLY in current code version (no git clone, no deployment):\n"
		printf "  bash deploy_prd.sh --ca-cl\n\n"
		printf "Flush cache ONLY in current code version (no git clone, no deployment):\n"
		printf "  bash deploy_prd.sh --ca-fl\n\n"
		exit 0 ;;

	--) shift; break ;;
	*) echo "Try -h for example usage."; exit 1 ;;

esac
done
