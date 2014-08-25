# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = ".ansible/playbook.yml"
    ansible.sudo = true
  end

  config.vm.post_up_message = <<MSG
URLs
  Website URL: http://meetspire.192.168.33.10.xip.io/

MySQL
  User: vagrant
  Password: vagrant
MSG
end
