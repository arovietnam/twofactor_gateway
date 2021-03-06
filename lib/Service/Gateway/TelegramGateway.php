<?php

declare(strict_types=1);

/**
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @author André Fondse <andre@hetnetwerk.org>
 *
 * Nextcloud - Two-factor Gateway for Telegram
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\TwoFactorGateway\Service\Gateway;

use Exception;
use OCA\TwoFactorGateway\Exception\SmsTransmissionException;
use OCA\TwoFactorGateway\Service\IGateway;
use OCP\Http\Client\IClient;
use OCP\Http\Client\IClientService;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IUser;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class TelegramGateway implements IGateway {

	/** @var IClient */
	private $client;

	/** @var IConfig */
	private $config;

	/** @var IL10N */
	private $l10n;

	public function __construct(IClientService $clientService,
								IConfig $config,
								IL10N $l10n) {
		$this->client = $clientService->newClient();
		$this->config = $config;
		$this->l10n = $l10n;
	}

	/**
	 * @param IUser $user
	 * @param string $idenfier
	 * @param string $message
	 *
	 * @throws \Telegram\Bot\Exceptions\TelegramSDKException
	 */
	public function send(IUser $user, string $idenfier, string $message) {
		$token = $this->config->getAppValue('twofactor_gateway', 'telegram_bot_token', null);
		// TODO: token missing handling

		$api = new Api($token);
		$chatId = $this->getChatId($user, $api, (int)$idenfier);

		$api->sendMessage([
			'chat_id' => $chatId,
			'text' => $message,
		]);
	}

	private function getChatId(IUser $user, Api $api, int $userId): int {
		$chatId = $this->config->getUserValue($user->getUID(), 'twofactor_gateway', 'telegram_chat_id', null);

		if (!is_null($chatId)) {
			return (int)$chatId;
		}

		$updates = $api->getUpdates();
		/** @var Update $update */
		$update = current(array_filter($updates, function (Update $data) use ($userId) {
			if ($data->message->text === "/start" && $data->message->from->id === $userId) {
				return true;
			}
			return false;
		}));
		// TODO: handle missing `/start` message and `$update` null values

		$chatId = $update->message->chat->id;
		$this->config->setUserValue($user->getUID(), 'twofactor_gateway', 'chat_id', $chatId);

		return (int)$chatId;
	}

	/**
	 * Get a short description of this gateway's name so that users know how
	 * their messages are delivered, e.g. "Telegram"
	 *
	 * @return string
	 */
	public function getShortName(): string {
		return 'Telegram';
	}

	/**
	 * @return string
	 */
	public function getProviderDescription(): string {
		return $this->l10n->t('Authenticate via Telegram');
	}
}
