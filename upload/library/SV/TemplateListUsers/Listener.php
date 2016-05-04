<?php

class SV_TemplateListUsers_Listener
{
    public static function template_hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
    {
        if ($hookName != 'sv_list_users')
        {
            return;
        }

        if (empty($hookParams['template']))
        {
            $hookParams['template'] = 'SVUserInfo';
        }

        if (empty($hookParams))
        {
            return;
        }

        static $userModel = null;
        if ($userModel === null)
        {
            $userModel = XenForo_Model::create('XenForo_Model_User');
        }

        $users = $userModel->getUsers($hookParams);
        if (empty($users))
        {
            return;
        }

        $template->preloadTemplate($hookParams['template']);
        foreach($users as $user)
        {
            $contents .= $template->create($hookParams['template'], array('user' => $user))->render();
        }

        return;
    }
}