<?php declare(strict_types=1);
/**
 * PrivateBin
 *
 * a zero-knowledge paste bin
 *
 * @link      https://github.com/PrivateBin/PrivateBin
 * @copyright 2012 Sébastien SAUVAGE (sebsauvage.net)
 * @license   https://www.opensource.org/licenses/zlib-license.php The zlib/libpng License
 */

namespace PrivateBin\Model;

use PrivateBin\Configuration;
use PrivateBin\Data\AbstractData;
use PrivateBin\Exception\TranslatedException;

/**
 * AbstractModel
 *
 * Abstract model for PrivateBin objects.
 */
abstract class AbstractModel
{
    /**
     * show the same error message if the data is invalid
     *
     * @const string
     */
    const INVALID_DATA_ERROR = 'Invalid data.';

    /**
     * show the same error message if the document ID already exists
     *
     * @const string
     */
    const COLLISION_ERROR = 'You are unlucky. Try again.';

    /**
     * Instance ID.
     *
     * @access protected
     * @var string
     */
    protected $_id = '';

    /**
     * Instance data.
     *
     * @access protected
     * @var array
     */
    protected $_data = ['meta' => []];

    /**
     * Configuration.
     *
     * @access protected
     * @var Configuration
     */
    protected $_conf;

    /**
     * Data storage.
     *
     * @access protected
     * @var AbstractData
     */
    protected $_store;

    /**
     * Instance constructor.
     *
     * @access public
     * @param  Configuration $configuration
     * @param  AbstractData $storage
     */
    public function __construct(Configuration $configuration, AbstractData $storage)
    {
        $this->_conf       = $configuration;
        $this->_store      = $storage;
    }

    /**
     * Get ID.
     *
     * @access public
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set ID.
     *
     * @access public
     * @param string $id
     * @throws TranslatedException
     */
    public function setId($id)
    {
        if (!self::isValidId($id)) {
            throw new TranslatedException('Invalid document ID.', 60);
        }
        $this->_id = $id;
    }

    /**
     * Set data and recalculate ID.
     *
     * @access public
     * @param  array $data
     * @throws TranslatedException
     */
    public function setData(array &$data)
    {
        $this->_sanitize($data);
        $this->_validate($data);
        $this->_data = $data;

        // IDs are generated server-side so that the URL suffix is always five digits.
        if (empty($this->_id)) {
            $this->setId($this->_generateId());
        }
    }

    /**
     * Get instance data.
     *
     * @access public
     * @return array
     */
    public function get()
    {
        return $this->_data;
    }

    /**
     * Store the instance's data.
     *
     * @access public
     * @throws TranslatedException
     */
    abstract public function store();

    /**
     * Test if current instance exists in store.
     *
     * @access public
     * @return bool
     */
    abstract public function exists();

    /**
     * Validate ID.
     *
     * @access public
     * @static
     * @param  string $id
     * @return bool
     */
    public static function isValidId($id)
    {
        return (bool) preg_match('#\A[0-9]{5}\z#', (string) $id);
    }

    /**
     * Generate an unused five-digit numeric ID.
     *
     * Starting at a cryptographically random point and then visiting every
     * possible value ensures we do not give up while an unused ID remains.
     *
     * @access protected
     * @throws TranslatedException
     * @return string
     */
    protected function _generateId()
    {
        $start = random_int(0, 99999);
        for ($offset = 0; $offset < 100000; $offset++) {
            $id = sprintf('%05d', ($start + $offset) % 100000);
            $this->setId($id);
            if (!$this->exists()) {
                return $id;
            }
        }

        throw new TranslatedException(self::COLLISION_ERROR, 75);
    }

    /**
     * Sanitizes data to conform with current configuration.
     *
     * @access protected
     * @param  array $data
     */
    abstract protected function _sanitize(array &$data);

    /**
     * Validate data.
     *
     * @access protected
     * @param  array $data
     * @throws TranslatedException
     */
    protected function _validate(array &$data)
    {
    }
}
