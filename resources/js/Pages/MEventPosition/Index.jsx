import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import { Link, useForm } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    Button,
    Center,
    Input,
    Stack,
    NativeSelect
} from '@chakra-ui/react';
import {
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
  } from "../../../../src/components/ui/dialog"
import { Field } from '../../../../src/components/ui/field';




const MEventPositions = ({m_event_positions, m_events}) => {

    // 検索フォームでuseFormの設定
    const {data, setData, get, delete:destroy} = useForm({
        'event_id': '', // フォームの入力値の初期値設定
    });

    // 入力フォームの値が変更された際のフォームの値の保持処理
    const handleChange = (e) => {
        console.log(e.target.name, e.target.value);
        setData(e.target.name, e.target.value);
    }

    // 検索ボタンがクリックされた際のHTTPのGET送信処理
    const hanldeSubmit = (e) => {
        //レンダリングをしない
        e.preventDefault();

        get(route('m_event_position.index'), {data})
    }

    const handleDelete = (id, e) => {
        //レンダリング防止
        e.preventDefault();
        console.log(id);

        destroy(route('m_event_position.destroy', id))
    }

    return (
        <ChakraProvider value={defaultSystem}>
        <>

            <CustomHeader />

            {/* メイン */}
                <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md'>
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle='2xl' m='20px'>ポジション・階級マスタ一覧</Text>

                        {/* 検索フォーム */}
                        <DialogRoot>
                            <DialogTrigger asChild>
                                <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem' w="10%">
                                    検索
                                </Button>
                            </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <Center>
                                            <DialogTitle>ポジション・階級マスタ検索</DialogTitle>
                                        </Center>
                                    </DialogHeader>
                                    <DialogBody>
                                        <form onSubmit={hanldeSubmit}>
                                            <HStack gap="1" m='1rem'>
                                                <Text w='20%' textAlign='center'>種目名</Text>
                                                <NativeSelect.Root>
                                                    <NativeSelect.Field placeholder='種目を選択してください' value={data.event_id} name='event_id' onChange={handleChange}>
                                                        {m_events.map((m_event, i) => <option key={i} value={m_event.id}>{m_event.event_name}</option>)}
                                                    </NativeSelect.Field>
                                                </NativeSelect.Root>
                                            </HStack>
                                            <Center m="6">
                                                <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%' >検索</Button>
                                            </Center>
                                        </form>
                                    </DialogBody>
                                <DialogCloseTrigger />
                            </DialogContent>
                        </DialogRoot>

                        {/* リセットボタン */}
                        <Button as={Link} href={`/m_event_positions`} bg='gray.500' p="0.5rem">リセット</Button>

                        {/* 登録フォーム */}
                        <Button as={Link} href={`/m_event_positions/create`} bg='orange.400' p="0.5rem">ポジション・階級登録</Button>

                    </HStack>

                    {/* テーブル */}
                    <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                        <Table.Root>
                            <Table.Header position="sticky" top="0" zIndex="1" bg="gray.400">
                                <Table.Row>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign="center" w="30%" fontSize={'md'}>種目</Table.ColumnHeader>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign="center" w="40%" fontSize={'md'}>ポシジョン・階級名</Table.ColumnHeader>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign="center" fontSize={'md'}>編集</Table.ColumnHeader>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign="center" fontSize={'md'}>削除</Table.ColumnHeader>
                                </Table.Row>
                            </Table.Header>

                            <Table.Body>
                                {m_event_positions.map((m_event_position, index) => (
                                    <Table.Row key={index}>
                                        <Table.Cell textAlign='center' borderBottom="1px solid" borderColor="gray.300">{m_event_position.m_event.event_name}</Table.Cell>
                                        <Table.Cell textAlign='center' borderBottom="1px solid" borderColor="gray.300">{m_event_position.event_position_name}</Table.Cell>
                                        <Table.Cell borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href={`/m_event_positions/edit/${m_event_position.id}`}>
                                                <Center>
                                                    <Image src="img/edit.png" />
                                                </Center>
                                            </Link>
                                        </Table.Cell>
                                        <Table.Cell borderBottom="1px solid" borderColor="gray.300">
                                            <Center>
                                                <Button onClick={ (e) => handleDelete(m_event_position.id, e) }>
                                                    <Image src="img/delete.png" />
                                                </Button>
                                            </Center>
                                        </Table.Cell>
                                    </Table.Row>
                                ))}
                            </Table.Body>
                        </Table.Root>

                    </Table.ScrollArea>

                </Box>

        </>
        </ChakraProvider>
    );
}

export default MEventPositions;
