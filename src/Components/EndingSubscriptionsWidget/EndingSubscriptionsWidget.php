<?php

namespace Crm\SubscriptionsModule\Components;

use Crm\ApplicationModule\Widget\BaseLazyWidget;

/**
 * This widget fetches all widgets from `subscriptions.endinglist` namespace
 * and renders panel with each widget as row.
 *
 * @package Crm\SubscriptionsModule\Components
 */
class EndingSubscriptionsWidget extends BaseLazyWidget
{
    private $templateName = 'ending_subscriptions_widget.latte';

    public function header($id = '')
    {
        return 'Ending subscriptions';
    }

    public function identifier()
    {
        return 'endingsubscriptionswidget';
    }

    public function render()
    {
        $widgets = $this->widgetManager->getWidgets('subscriptions.endinglist');
        foreach ($widgets as $sorting => $widget) {
            if (!($widget instanceof IWidgetLegend)) {
                throw new \Exception(sprintf("registered widget instance doesn't implement IWidgetLegend: %s", gettype($widget)));
            }
            if (!$this->getComponent($widget->identifier())) {
                $this->addComponent($widget, $widget->identifier());
            }
        }

        $this->template->widgets = $widgets;
        $this->template->setFile(__DIR__ . '/' . $this->templateName);
        $this->template->render();
    }
}
